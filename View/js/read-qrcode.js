const scanner = new Html5QrcodeScanner('reader', {
  qrbox:{
      width: 250,
      height: 250
  },
  fps: 20,
  supportedScanTypes: [
  Html5QrcodeScanType.SCAN_TYPE_CAMERA
]
});

scanner.render(success, error);

function success(result)
{
  window.location.href = result;
  scanner.clear();

}

function error(err)
{
  console.error(err);
}