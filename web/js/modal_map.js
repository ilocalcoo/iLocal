function init() {
  let coords = $('#link-map').attr('data-coords').split(',');
  if (Object.keys(coords).length == 1) {
    // Если координат в БД нет, переводим адрес в координаты с помощью
    // геокодеса яндекса https://tech.yandex.ru/maps/jsbox/2.1/direct_geocode
    let address = $('#link-map').text();
    ymaps.geocode(address, {
      results: 1
    }).then(function (res) {
      // В случае успешного поиска объекта по адресу, создаем карту и добавляем объект
      let firstGeoObject = res.geoObjects.get(0);
      coords = firstGeoObject.geometry._coordinates;
      let myMap = new ymaps.Map('show-map', {
          center: coords,
          zoom: 15
        }
      );
      myMap.geoObjects.add(firstGeoObject);
    })
  } else {
    // Если координаты есть в БД, то сразу создаем карту и объект в центре
    let myMap = new ymaps.Map('show-map', {
        center: coords,
        zoom: 15
      }
    );

    let myGeoObject = new ymaps.GeoObject({
      geometry: {
        type: "Point", // тип геометрии - точка
        coordinates: coords // координаты точки
      }
    });

    // Размещение геообъекта на карте.
    myMap.geoObjects.add(myGeoObject);
  }

}


ymaps.ready(init);