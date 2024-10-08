let html5QrCode;

function initializeScanner() {
    // Check if Html5Qrcode is defined
    if (typeof Html5Qrcode === "undefined") {
        console.error("Html5Qrcode is not defined. Retrying in 1 second...");
        setTimeout(initializeScanner, 1000); // Retry after 1 second
        return;
    }

    const readerElement = document.getElementById("reader");

    // Check if the reader element exists
    if (!readerElement) {
        console.error("HTML element with id 'reader' not found");
        return; // Exit if the element is not found
    }

    // Initialize the QR code scanner
    html5QrCode = new Html5Qrcode(readerElement);

    // Start scanning
    html5QrCode.start(
        { facingMode: "environment" },
        { fps: 10, qrbox: { width: 250, height: 250 } },
        onScanSuccess,
        onScanError
    ).catch(err => {
        console.error('Error starting QR Code scanner:', err);
        alert('Failed to start QR Code scanner. Please check your camera permissions.');
    });

    // Generate a QR code with the payload data
    generateQRCode();
}

// Modify the generateQRCode function
function generateQRCode() {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const courseId = document.getElementById('course_id').value;
    const classroomId = document.getElementById('classroom_id').value;
    const lessonTime = document.getElementById('lesson_time').value;

    const payload = `${courseId} ${classroomId} ${lessonTime}`;
    
    const qrcodeElement = document.getElementById('qrcode');
    
    if (qrcodeElement && typeof QRCode !== "undefined") {
        QRCode.toCanvas(qrcodeElement, payload, function (error) {
            if (error) {
                console.error('Error generating QR code:', error);
            } else {
                console.log('QR code generated successfully!');
            }
        });
    } else {
        console.error('QR code element not found or QRCode library not loaded');
    }
}

// Add an event listener to generate QR code when form inputs change
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('#course_id, #classroom_id, #lesson_time');
    inputs.forEach(input => {
        input.addEventListener('change', generateQRCode);
    });
});

// Function to handle successful QR code scan
function onScanSuccess(decodedText) {
    console.log('Scanned QR code data:', decodedText);
    const qr_code_id = extractQrCodeId(decodedText);
    
    if (qr_code_id === null) {
        alert('Error: Missing required data.');
        return;
    }

    // Send the scanned data to the server
    recordData(qr_code_id);
}

// Function to send scanned QR code ID to the server
function recordData(qr_code_id) {
    fetch('/dashboard/scan-qr', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF token
        },
        body: JSON.stringify({ qr_code_id: qr_code_id }) // Retaining the original variable name
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
    // Assuming QR code data is space-separated; modify as needed
    const parts = decodedText.split(' ');
    const id = parseInt(parts[0], 10); // Convert to integer
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

// Function to generate a QR code
function generateQRCode(data, element) {
    QRCode.toCanvas(element, data, function (error) {
        if (error) {
            console.error('Error generating QR code:', error);
        } else {
            console.log('QR code generated!');
        }
    });
}

// Initialize the HTML5 QR code scanner when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', initializeScanner);
