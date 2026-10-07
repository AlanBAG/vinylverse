<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Vinilos</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { margin: 0; color: #1a1a1a; }
        .header p { margin: 5px 0 0 0; color: #666; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 12px; }
        th { background-color: #343a40; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
    </style>
</head>
<body>

<div class="header">
    <h1>Tienda de Vinilos - Catálogo</h1>
    <p>Reporte generado el: {{ date('d/m/Y H:i:s') }}</p>
</div>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Género</th>
        <th>Precio</th>
        <th>Stock</th>
    </tr>
    </thead>
    <tbody>
    @foreach($vinilos as $vinilo)
    <tr>
        <td>{{ $vinilo->id }}</td>
        <td>{{ $vinilo->titulo }}</td>
        <td>{{ $vinilo->genero }}</td>
        <td>${{ number_format($vinilo->precio, 2) }}</td>
        <td>{{ $vinilo->stock }} unidades</td>
    </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
