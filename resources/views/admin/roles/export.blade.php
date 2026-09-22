<!doctype html>
<html>
<head><meta charset="UTF-8"><style>body{font-family:Arial,sans-serif;font-size:12px}table{width:100%;border-collapse:collapse}th,td{border:1px solid #ddd;padding:8px;text-align:left}th{background:#f4f4f4}</style></head>
<body>
<h1>Roles Report</h1>
<table>
    <thead><tr><th>Name</th><th>Description</th><th>Permissions</th></tr></thead>
    <tbody>
        @foreach($roles as $role)
            <tr><td>{{ $role->name }}</td><td>{{ $role->description }}</td><td>{{ implode(', ', $role->permissions ?? []) }}</td></tr>
        @endforeach
    </tbody>
</table>
</body>
</html>