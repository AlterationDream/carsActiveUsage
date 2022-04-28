<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Список API</title>

    <style>

        details {
            display: inline-block;
            border: 1px solid #aaa;
            border-radius: 4px;
            padding: .5em .5em 0;
            margin-bottom: 8px;
            font-family: monospace;
            font-size: 22px;
        }

        summary {
            font-weight: bold;
            margin: -.5em -.5em 0;
            padding: .5em;
        }

        details[open] {
            padding: .5em;
        }

        details[open] > summary {
            border-bottom: 1px solid #aaa;
            margin-bottom: .5em;
        }

        .result {
            border: 1px solid black;
            margin-bottom: 16px;
            padding: 12px;
            background: #010102;
            color: white;
            font-size: 22px;
            font-family: monospace;
            line-break: anywhere;
            max-width: 1024px;
        }
    </style>
</head>
<body>
    <div class="result">

    </div>
    <details>
        <summary>
            Менеджмент активного списка использований автомобилей
        </summary>

        <details>
            <summary>
                /api/active-uses/list - Получить список использований
            </summary>

            <input type="checkbox" id="active_uses-list-option">
            <label>limit</label>
            <input type="number" id="active_uses-list-limit" value="-1">
            <br>
            <button onclick="activeUsesAPI('list')">Получить</button>
        </details>

        <br>

        <details>
            <summary>
                /api/active-uses/create - Добавить активное использование
            </summary>

            <label>user_id</label>
            <input type="number" id="active_uses-create-user_id">
            <br>
            <label>car_id</label>
            <input type="number" id="active_uses-create-car_id">
            <br>
            <button onclick="activeUsesAPI('create')">Добавить</button>
        </details>

        <br>

        <details>
            <summary>
                /api/active-uses/update - Редактировать активное использование
            </summary>

            <label>id</label>
            <input type="number" id="active_uses-update-id" min="1">
            <br>
            <label>user_id</label>
            <input type="number" id="active_uses-update-user_id">
            <br>
            <label>car_id</label>
            <input type="number" id="active_uses-update-car_id">
            <br>
            <button onclick="activeUsesAPI('update')">Изменить</button>
        </details>

        <br>

        <details>
            <summary>
                /api/active-uses/delete - Удалить активное использование
            </summary>

            <label>id</label>
            <input type="number" id="active_uses-delete-id">
            <br>
            <button onclick="activeUsesAPI('delete')">Удалить</button>
        </details>
    </details>
    <br>
    <details>
        <summary>
            Менеджмент автомобилей
        </summary>

        <details>
            <summary>
                /api/cars/list - Получить список автомобилей
            </summary>

            <input type="checkbox" id="cars-list-option">
            <label>limit</label>
            <input type="number" id="cars-list-limit" value="-1">
            <br>
            <button onclick="carsAPI('list')">Получить</button>
        </details>

        <br>

        <details>
            <summary>
                /api/cars/create - Добавить автомобиль
            </summary>

            <label>name</label>
            <input type="text" id="cars-create-name">
            <br>
            <button onclick="carsAPI('create')">Добавить</button>
        </details>

        <br>

        <details>
            <summary>
                /api/cars/update - Редактировать автомобиль
            </summary>

            <label>id</label>
            <input type="number" id="cars-update-id">
            <br>
            <label>name</label>
            <input type="text" id="cars-update-name">
            <br>
            <button onclick="carsAPI('update')">Изменить</button>
        </details>

        <br>

        <details>
            <summary>
                /api/cars/delete - Удалить автомобиль
            </summary>

            <label>id</label>
            <input type="number" id="cars-delete-id">
            <br>
            <button onclick="carsAPI('delete')">Удалить</button>
        </details>
    </details>
    <br>
    <details>
        <summary>
            Менеджмент водителей
        </summary>

        <details>
            <summary>
                /api/users/list - Получить список водителей
            </summary>

            <input type="checkbox" id="users-list-option">
            <label>limit</label>
            <input type="number" id="users-list-limit" value="-1">
            <br>
            <button onclick="usersAPI('list')">Получить</button>
        </details>

        <br>

        <details>
            <summary>
                /api/users/create - Добавить водителя
            </summary>

            <label>name</label>
            <input type="text" id="users-create-name">
            <br>
            <button onclick="usersAPI('create')">Добавить</button>
        </details>

        <br>

        <details>
            <summary>
                /api/users/update - Редактировать водителя
            </summary>

            <label>id</label>
            <input type="number" id="users-update-id">
            <br>
            <label>name</label>
            <input type="text" id="users-update-name">
            <br>
            <button onclick="usersAPI('update')">Изменить</button>
        </details>

        <br>

        <details>
            <summary>
                /api/cars/delete - Удалить водителя
            </summary>

            <label>id</label>
            <input type="number" id="users-delete-id">
            <br>
            <button onclick="usersAPI('delete')">Удалить</button>
        </details>
    </details>

    <script>
        function activeUsesAPI(query) {
            let arguments = {};
            switch (query) {
                case 'list':
                    let limitOption = document.getElementById('active_uses-list-option').checked;
                    if (limitOption) {
                        arguments = {
                            limit : document.getElementById('active_uses-list-limit').value
                        };
                        sendPost('api/active-uses/list', arguments);
                        break;
                    }
                    sendPost('api/active-uses/list');
                    break;
                case 'create':
                    arguments = {
                        car_id : document.getElementById('active_uses-create-car_id').value,
                        user_id : document.getElementById('active_uses-create-user_id').value
                    };
                    sendPost('api/active-uses/create', arguments);
                    break;
                case 'update':
                    arguments = {
                        id : document.getElementById('active_uses-update-id').value,
                        car_id : document.getElementById('active_uses-update-car_id').value,
                        user_id : document.getElementById('active_uses-update-user_id').value
                    };
                    sendPost('api/active-uses/update', arguments);
                    break;
                case 'delete':
                    arguments = {
                        id : document.getElementById('active_uses-delete-id').value
                    };
                    sendPost('api/active-uses/delete', arguments);
                    break;
            }
        }

        function carsAPI(query) {
            let arguments = {};
            switch (query) {
                case 'list':
                    let limitOption = document.getElementById('cars-list-option').checked;
                    if (limitOption) {
                        arguments = {
                            limit : document.getElementById('cars-list-limit').value
                        };
                        sendPost('api/cars/list', arguments);
                        break;
                    }
                    sendPost('api/cars/list');
                    break;
                case 'create':
                    arguments = {
                        name : document.getElementById('cars-create-name').value,
                    };
                    sendPost('api/cars/create', arguments);
                    break;
                case 'update':
                    arguments = {
                        id : document.getElementById('cars-update-id').value,
                        name : document.getElementById('cars-update-name').value,
                    };
                    sendPost('api/cars/update', arguments);
                    break;
                case 'delete':
                    arguments = {
                        id : document.getElementById('cars-delete-id').value
                    };
                    sendPost('api/cars/delete', arguments);
                    break;
            }
        }

        function usersAPI(query) {
            let arguments = {};
            switch (query) {
                case 'list':
                    let limitOption = document.getElementById('users-list-option').checked;
                    if (limitOption) {
                        arguments = {
                            limit : document.getElementById('users-list-limit').value
                        };
                        sendPost('api/users/list', arguments);
                        break;
                    }
                    sendPost('api/users/list');
                    break;
                case 'create':
                    arguments = {
                        name : document.getElementById('users-create-name').value,
                    };
                    sendPost('api/users/create', arguments);
                    break;
                case 'update':
                    arguments = {
                        id : document.getElementById('users-update-id').value,
                        name : document.getElementById('users-update-name').value,
                    };
                    sendPost('api/users/update', arguments);
                    break;
                case 'delete':
                    arguments = {
                        id : document.getElementById('users-delete-id').value
                    };
                    sendPost('api/users/delete', arguments);
                    break;
            }
        }

        function sendPost(url, arguments = {}) {
            event.preventDefault();
            var xhr = new XMLHttpRequest();
            xhr.open("POST", url, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (this.readyState === XMLHttpRequest.DONE) {
                    document.querySelectorAll('div.result')[0].innerText = this.responseText;
                }
            }
            console.log("_token={{ csrf_token() }}" + fillArgs(arguments));
            xhr.send("_token={{ csrf_token() }}" + fillArgs(arguments));
            return false;
        }

        function fillArgs(arguments) {
            let args = '';
            Object.entries(arguments).forEach(entry => {
                const [key, value] = entry;
                args += '&' + key + '=' + value;
            });
            return args;
        }
    </script>
</body>
