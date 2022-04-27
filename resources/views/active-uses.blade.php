<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Водители</title>

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
    <a href="/users">Водители</a>
    <a href="/cars">Автомобили</a>
</div>
<div style="margin-top: 12px;">
    <form action="create" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <label for="car_id">Автомобиль</label>
        <select name="car_id" id="cars">
            @foreach($cars as $car)
                <option value="{{ $car->id }}">{{ $car->name }}</option>
            @endforeach
        </select>
        <label for="user_id">Водитель</label>
        <select name="user_id" id="users">
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
        <input type="submit" value="Добавить">
    </form>
</div>
<div>
    <table>
        <thead>
        <tr>
            <th>Автомобиль</th>
            <th>Водитель</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($activeUses as $activeUse)
            <tr activeUse-id="{{ $activeUse->id }}">
                <?php
                    $car = $cars->find($activeUse->car_id);
                    $user = $users->find($activeUse->user_id);
                ?>
                <td car_id="{{ $car->id }}">{{ $car->name }}</td>
                <td user_id="{{ $user->id }}">{{ $user->name }}</td>
                <td onclick="editUse({{ $activeUse->id }})">Редактировать</td>
                <td onclick="deleteUse({{ $activeUse->id }})">Удалить</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<script>
    function editUse(id) {
        let tr = document.querySelectorAll('tr[activeUse-id="' + id + '"]')[0];
        let car_id = tr.children[0].getAttribute('car_id');
        let car_name = tr.children[0].innerText;
        let user_id = tr.children[1].getAttribute('user_id');
        let user_name = tr.children[1].innerText;
        tr.children[0].innerHTML = document.querySelectorAll('#cars')[0].outerHTML;
        tr.children[0].children[0].value = car_id;
        tr.children[1].innerHTML = document.querySelectorAll('#users')[0].outerHTML;
        tr.children[1].children[0].value = user_id;
        tr.children[2].setAttribute("onclick", 'saveUse(' + id + ')');
        tr.children[2].innerText = 'Сохранить';
        tr.children[3].setAttribute("onclick", 'cancelSave(' + id + ')');
        tr.children[3].innerText = 'Отменить';
        let hid1 = document.createElement('input');
        hid1.type = 'hidden';
        hid1.className = 'hidden-car';
        hid1.setAttribute('car-id', car_id);
        hid1.value = car_name;
        let hid2 = document.createElement('input');
        hid2.type = 'hidden';
        hid2.className = 'hidden-user';
        hid1.setAttribute('user-id', user_id);
        hid2.value = user_name;
        tr.children[3].appendChild(hid1);
        tr.children[3].appendChild(hid2);
    }

    function saveUse(id) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", 'edit', true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                location.reload();
            }
        }
        let car_id = document.querySelectorAll('tr[activeUse-id="' + id + '"] select[name="car_id"]')[0].value;
        let user_id = document.querySelectorAll('tr[activeUse-id="' + id + '"] select[name="user_id"]')[0].value;
        xhr.send("_token={{ csrf_token() }}&id=" + id + "&car_id=" + car_id + "&user_id=" + user_id);
    }

    function cancelSave(id) {
        let tr = document.querySelectorAll('tr[activeUse-id="' + id + '"]')[0];
        tr.children[0].innerText = tr.querySelectorAll('input.hidden-car')[0].value;
        tr.children[1].innerText = tr.querySelectorAll('input.hidden-user')[0].value;
        tr.children[2].setAttribute("onclick", 'editUse(' + id +')');
        tr.children[2].innerText = 'Редактировать';
        tr.children[3].setAttribute("onclick", 'deleteUse(' + id + ')');
        tr.children[3].innerText = 'Удалить';
    }

    function deleteUse(id) {
        let isSure = confirm("Удалить запись об использовании автомобиля?");
        if (!isSure) return false;
        var xhr = new XMLHttpRequest();
        xhr.open("POST", 'remove', true);
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
