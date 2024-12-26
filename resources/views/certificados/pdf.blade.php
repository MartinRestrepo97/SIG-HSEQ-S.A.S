<!DOCTYPE html>
<html>
<head>
    <title>Certificado</title>
</head>
<body>
    <h1>Certificado de {{ $certificado->nombre }}</h1>
    <p>Emitido a: {{ $cliente->nombre }}</p>
    <p>Email: {{ $cliente->email }}</p>
</body>
</html>