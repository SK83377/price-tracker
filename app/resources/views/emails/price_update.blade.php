<!DOCTYPE html>
<html>
<head>
    <title>Price Updates</title>
</head>
<body>
    <h1>Price Updates</h1>
    <ul>
        @foreach ($updatedPrices as $item)
            <li>{{ $item['url'] }}: {{ $item['price'] }}</li>
        @endforeach
    </ul>
</body>
</html>