const html5QrCode = new Html5Qrcode("reader");
const qrCodeSuccessCallback = (decodedText, decodedResult) => {
    window.location.href = decodedText;
    html5QrCode.stop() // para de escanear
};
const config = { fps: 10, qrbox: { width: 230, height: 230 } };

html5QrCode.start({ facingMode: "environment" }, config, qrCodeSuccessCallback);