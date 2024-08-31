<!DOCTYPE html>
<html>
<head>
    <title>Handle PDF</title>
</head>
<body>
    <h1>Choose an Option</h1>
    <form id="printForm" action="{{ route('pdf.generate') }}" method="POST" style="display:none;">
        @csrf
    </form>
    <button id="printBtn">Print</button>
    <button id="downloadBtn">Download</button>

    <iframe id="pdfFrame" src="{{ asset('document.html') }}" style="display:none;"></iframe>

    <script>
        document.getElementById('printBtn').addEventListener('click', function() {
            console.log('Print option selected');
            document.getElementById('printForm').submit();
        });

        document.getElementById('downloadBtn').addEventListener('click', function() {
            console.log('Download option selected');
            window.location.href = "{{ route('pdf.download') }}";
        });
    </script>
</body>
</html>
