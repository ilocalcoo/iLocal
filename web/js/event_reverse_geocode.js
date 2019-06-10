ymaps.ready(init);

function init() {
    var userCoords = document.getElementById("user_coordinates");
    if (userCoords) {
        userCoords = userCoords.innerText.split(", ");
    } else {
        userCoords = [55.753994, 37.622093];
    }
    var myPlacemark,
        myMap = new ymaps.Map('profile_map', {
            center: userCoords,
            // center: [55.753994, 37.622093],
            zoom: 13
        }, {
            searchControlProvider: 'yandex#search'
        }),
        myGeoObject = new ymaps.GeoObject({
            // Описание геометрии.
            geometry: {
                type: "Point",
                coordinates: userCoords
            },
            // Свойства.
            properties: {
                // Контент метки.
                // iconContent: '',
                // hintContent: ''
            }
        }, {
            // Опции.
            // Иконка метки будет растягиваться под размер ее содержимого.
            // preset: 'islands#blackStretchyIcon',
            // Метку можно перемещать.
            // draggable: true
        });

    myMap.geoObjects.add(myGeoObject);

    // Слушаем клик на карте.
    myMap.events.add('click', function (e) {
        var coords = e.get('coords');

        // Если метка уже создана – просто передвигаем ее.
        if (myPlacemark) {
            myPlacemark.geometry.setCoordinates(coords);
        }
        // Если нет – создаем.
        else {
            myPlacemark = createPlacemark(coords);
            myMap.geoObjects.add(myPlacemark);
            // Слушаем событие окончания перетаскивания на метке.
            myPlacemark.events.add('dragend', function () {
                getAddress(myPlacemark.geometry.getCoordinates());
            });
        }
        getAddress(coords);
    });

    // Создание метки.
    function createPlacemark(coords) {
        return new ymaps.Placemark(coords, {
            iconCaption: 'поиск...'
        }, {
            preset: 'islands#violetDotIconWithCaption',
            draggable: true
        });
    }

    // Определяем адрес по координатам (обратное геокодирование).
    function getAddress(coords) {
        myPlacemark.properties.set('iconCaption', 'поиск...');
        ymaps.geocode(coords).then(function (res) {
            var firstGeoObject = res.geoObjects.get(0);

            myPlacemark.properties
                .set({
                    // Формируем строку с данными об объекте.
                    iconCaption: [
                        // Название населенного пункта или вышестоящее административно-территориальное образование.
                        firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
                        // Получаем путь до топонима, если метод вернул null, запрашиваем наименование здания.
                        firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()
                    ].filter(Boolean).join(', '),
                    // В качестве контента балуна задаем строку с адресом объекта.
                    balloonContent: firstGeoObject.getAddressLine()
                });

            var addressArray = [
                firstGeoObject.getLocalities()[0],
                firstGeoObject.getThoroughfare(),
                firstGeoObject.getPremiseNumber(),
                coords
            ];
            var hiddenInput = document.getElementById('profile_address');
            hiddenInput.setAttribute('value', addressArray);
        });
    }
}
