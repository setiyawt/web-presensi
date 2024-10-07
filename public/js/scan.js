let html5QrCode;

function initializeScanner() {
    // Check if Html5Qrcode is defined
    if (typeof Html5Qrcode === "undefined") {
        console.error("Html5Qrcode is not defined. Retrying in 1 second...");
        setTimeout(initializeScanner, 1000);
        return;
    }

    const readerElement = document.getElementById("reader");

    // Check if the reader element exists
    if (!readerElement) {
        console.error("HTML element with id 'reader' not found");
        return; // Exit if the element is not found
    }

    html5QrCode = new Html5Qrcode(readerElement);

    html5QrCode.start(
        { facingMode: "environment" },
        { fps: 10, qrbox: { width: 250, height: 250 } },
        onScanSuccess,
        onScanError
    ).catch(err => {
        console.error('Error starting QR Code scanner:', err);
        alert('Failed to start QR Code scanner. Please check your camera permissions.');
    });
}

// Function to handle successful QR code scan
function onScanSuccess(decodedText) {
    console.log('Scanned QR code data:', decodedText);
    const qr_code_id = extractQrCodeId(decodedText);
    
    if (qr_code_id === null) {
        alert('Error: Missing required data.');
        return;
    }
    
    fetch('/dashboard/scan-qr', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ qr_code_id: qr_code_id })
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => { throw err; });
        }
        return response.json();
    })
    .then(data => {
        console.log('Server response:', data);
        alert(data.success || 'Data successfully recorded!');
    })
    .catch(error => {
        console.error('Error:', error);
        alert(error.error || 'Failed to record data. Please try again.');
    });
}

// Function to extract qr_code_id from the QR code data
function extractQrCodeId(decodedText) {
    // Example: Assuming QR code data is space-separated
    const parts = decodedText.split(' ');
    const id = parseInt(parts[0], 10);
    if (isNaN(id)) {
        console.error('Invalid QR code ID:', decodedText);
        return null;
    }
    return id;
}

// Function to handle QR code scan errors
function onScanError(errorMessage) {
    console.error('QR Code scan error:', errorMessage);
}

// Initialize the HTML5 QR code scanner when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', initializeScanner);
