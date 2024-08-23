
let html5QrCode;

function initializeScanner() {
    if (typeof Html5Qrcode === "undefined") {
        console.error("Html5Qrcode is not defined. Retrying in 1 second...");
        setTimeout(initializeScanner, 1000);
        return;
    }

    html5QrCode = new Html5Qrcode("reader");

    html5QrCode.start(
        { facingMode: "environment" },
        { fps: 10, qrbox: { width: 250, height: 250 } },
        onScanSuccess,
        onScanError
    ).catch(err => {
        console.error('Error starting QR Code scanner:', err);
    });

    // Generate a QR code for demonstration
    QRCode.toCanvas(document.getElementById('qrcode'), 'http://jindo.dev.naver.com/collie', function (error) {
        if (error) console.error(error);
        console.log('QR code generated!');
    });
}

// Function to handle successful QR code scan
function onScanSuccess(decodedText) {
    console.log('Scanned QR code data:', decodedText);
 
    fetch('/scan-qr', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ qr_code_path: decodedText })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Server response:', data);
        alert('Data successfully recorded!');
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to record data. Please try again.');
    });
}

// Function to handle QR code scan errors
function onScanError(errorMessage) {
    console.error('QR Code scan error:', errorMessage);
}

// Initialize the HTML5 QR code scanner
document.addEventListener('DOMContentLoaded', initializeScanner);
