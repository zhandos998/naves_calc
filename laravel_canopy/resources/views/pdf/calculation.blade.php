<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
        }
        .block {
            margin-bottom: 10px;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        td, th { border: 1px solid #ccc; padding: 6px; text-align: left; }
        img { height: 400px;}
    </style>
</head>
<body>
    <h2>Расчёт навеса</h2>

    <table>
        <tr><th>Ширина</th><td>{{ $data['width'] }} м</td></tr>
        <tr><th>Длина</th><td>{{ $data['length'] }} м</td></tr>
        <tr><th>Высота</th><td>{{ $data['height'] }} м</td></tr>
        <tr><th>Толщина столбцов</th><td>{{ $data['post_thickness'] }} м</td></tr>
        <tr><th>Форма</th><td>{{ $data['frame_type'] }}</td></tr>
        <tr><th>Площадь</th><td>{{ $data['area'] }} м²</td></tr>
        <tr><th>Материалы</th><td>{{ number_format($data['materials'], 0, '.', ' ') }} ₸</td></tr>
        <tr><th>Расходные материалы</th><td>{{ number_format($data['consumables'], 0, '.', ' ') }} ₸</td></tr>
        <tr><th>Производство</th><td>{{ number_format($data['manufacturing'], 0, '.', ' ') }} ₸</td></tr>
        <tr><th>Монтаж</th><td>{{ number_format($data['installation'], 0, '.', ' ') }} ₸</td></tr>
        <tr><th>Доставка</th><td>{{ number_format($data['delivery'], 0, '.', ' ') }} ₸</td></tr>
        <tr><th>Скидка</th><td>-{{ number_format($data['discount'], 0, '.', ' ') }} ₸</td></tr>
        <tr><th>Итого</th><td>{{ number_format($data['final'], 0, '.', ' ') }} ₸</td></tr>
    </table>

    @if (!empty($data['canvas_image']))
        <h3 style="margin-top: 30px;">Изображение визуализации:</h3>
        <img src="{{ $data['canvas_image'] }}" />

        {{-- <img src="{{ $data['canvas_image'] }}" style="width:100%; max-width:600px;"> --}}
    @endif
</body>
</html>
