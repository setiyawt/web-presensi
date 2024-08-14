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
function onScanSuccess(decodedText, decodedResult) {
    document.getElementById('result').textContent = `QR Code Data: ${decodedText}`;

    fetch('/scan-qr', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ qrData: decodedText })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
        alert('Data successfully recorded!');
    })
    .catch(error => {
        console.error('Error:', error);
    });

    // Stop scanning after successful scan
    html5QrCode.stop().then(() => {
        console.log('QR Code scanning stopped.');
    }).catch(err => {
        console.error('Error stopping QR Code scanning:', err);
    });
}

// Function to handle QR code scan errors
function onScanError(errorMessage) {
    console.error('QR Code scan error:', errorMessage);
}

// Initialize the HTML5 QR code scanner
document.addEventListener('DOMContentLoaded', initializeScanner);
