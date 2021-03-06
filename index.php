<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Deezer decoder</title>
</head>
<body>
<form id="form">
    Encoded MP3: <input type="file" id="file" accept="audio/mpeg">
    <input type="hidden" min="0" id="songId" value="<?php echo $_GET['song_id'] ?>"><br><br>
    <button type="submit">Decode</button>
</form>
<script src="tools/FileSaver.1.3.3.min.js"></script>
<script src="dist/deezerDecoder.js"></script>
<script>
    document.getElementById('form').addEventListener('submit', function (e) {
        e.preventDefault();
        const fileInput = document.getElementById('file');
        const songInput = document.getElementById('songId');

        if (!fileInput.files.length) {
            console.error('Did you forget attach a file?');
            return;
        }
        const file = fileInput.files[0];
        const reader = new FileReader();
        reader.onload = function () {
            decode(reader.result, songInput.value, file.name);
        };
        reader.onerror = function () {
            console.error('Reader error', reader.error);
        };
        reader.readAsArrayBuffer(file);
    });

    function decode(arrayBuffer, songId, name) {
        const decoded = deezerDecoder(arrayBuffer, songId);
        const blob = new Blob([decoded], {type: 'audio/mpeg'});
        saveAs(blob, name);
    }
</script>
</body>
</html>
