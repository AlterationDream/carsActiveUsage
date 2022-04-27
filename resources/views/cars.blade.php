<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Автомобили</title>

    <style>
        table {
            margin-top: 12px;
            text-align: left;
            border-collapse: collapse;
        }
        table td {
            border: 1px solid black;
            padding: 3px 6px;
        }
    </style>
</head>
<body>
<div>
    <a href="/">Использование автомобилей</a>
    <a href="/users">Водители</a>
</div>
<div style="margin-top: 12px;">
    <form action="/cars/create" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <label for="name">Название машины</label>
        <input type="text" name="name">
        <input type="submit" value="Добавить">
    </form>
</div>
<div>
    <table>
        <thead>
        <tr>
            <th>Название машины</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($cars as $car)
            <tr car-id="{{ $car->id }}">
                <td>{{ $car->name }}</td>
                <td onclick="editCar({{ $car->id }})">Редактировать</td>
                <td onclick="deleteCar({{ $car->id }})">Удалить</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<script>
    function editCar(id) {
        let tr = document.querySelectorAll('tr[car-id="' + id + '"]')[0];
        let name = tr.children[0].innerText;
        tr.children[0].innerHTML = '<input type="text" value="' + name +'">';
        tr.children[1].setAttribute("onclick", 'saveCar(' + id + ')');
        tr.children[1].innerText = 'Сохранить';
        tr.children[2].setAttribute("onclick", 'cancelSave(' + id + ')');
        tr.children[2].innerText = 'Отменить';
        let hid = document.createElement('input');
        hid.type = 'hidden';
        hid.className = 'hidden-name';
        hid.value = name;
        tr.children[2].appendChild(hid);
    }

    function saveCar(id) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", '/cars/edit', true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                location.reload();
            }
        }
        let name = document.querySelectorAll('tr[car-id="' + id + '"] input')[0].value;
        xhr.send("_token={{ csrf_token() }}&id=" + id + "&name=" + name);
    }

    function cancelSave(id) {
        let tr = document.querySelectorAll('tr[car-id="' + id + '"]')[0];
        tr.children[0].innerText = tr.querySelectorAll('input.hidden-name')[0].value;
        tr.children[1].setAttribute("onclick", 'editCar(' + id +')');
        tr.children[1].innerText = 'Редактировать';
        tr.children[2].setAttribute("onclick", 'deleteCar(' + id +')');
        tr.children[2].innerText = 'Удалить';
    }

    function deleteCar(id) {
        let isSure = confirm("Удалить автомобиль?");
        if (!isSure) return false;
        var xhr = new XMLHttpRequest();
        xhr.open("POST", '/cars/remove', true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                location.reload();
            }
        }
        xhr.send("_token={{ csrf_token() }}&id=" + id);
    }
</script>
</body>
