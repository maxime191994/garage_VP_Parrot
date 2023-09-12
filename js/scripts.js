$(document).ready(function () {
  // Configuration des sliders
  var kilometrageSlider = document.getElementById('kilometrageSlider');
  var anneeSlider = document.getElementById('anneeSlider');
  var prixSlider = document.getElementById('prixSlider');

  noUiSlider.create(kilometrageSlider, {
    start: [0, 100000], // Valeurs initiales min et max
    connect: true, // Connectez les poignées
    step: 1000, // Incréments de 1000
    range: {
      'min': 0,
      'max': 100000
    }
  });

  noUiSlider.create(anneeSlider, {
    start: [1920, 2023], // Plage d'années
    connect: true,
    step: 1,
    range: {
      'min': 1920,
      'max': 2023
    }
  });

  noUiSlider.create(prixSlider, {
    start: [0, 100000], // Plage de prix
    connect: true,
    step: 1000,
    range: {
      'min': 0,
      'max': 100000
    }
  });

  // Fonction pour mettre à jour la liste des véhicules en fonction des sliders
  function updateVehicleList() {
    var kilometrageRange = kilometrageSlider.noUiSlider.get();
    var anneeRange = anneeSlider.noUiSlider.get();
    var prixRange = prixSlider.noUiSlider.get();

    $.ajax({
      url: "get_filtered_vehicles.php",
      type: "POST",
      data: {
        kilometrageMin: kilometrageRange[0],
        kilometrageMax: kilometrageRange[1],
        anneeMin: anneeRange[0],
        anneeMax: anneeRange[1],
        prixMin: prixRange[0],
        prixMax: prixRange[1]
      },
      success: function (data) {
        $(".vehicle-list").html(data);
      },
      error: function () {
        alert("Une erreur s'est produite lors de la récupération des véhicules.");
      }
    });
  }

  // Fonction pour mettre à jour les valeurs des sliders
  function updateSliderValues(slider, valuesDiv, unit) {
    slider.noUiSlider.on('update', function (values, handle) {
      var formattedValues = values.map(function (value) {
        return parseInt(value);
      });
      valuesDiv.innerHTML = formattedValues.join(' - ') + ' ' + unit;
    });
  }

  // Mettez à jour les valeurs des sliders avec les divs correspondantes
  updateSliderValues(kilometrageSlider, document.getElementById('kilometrageValues'), 'km');
  updateSliderValues(anneeSlider, document.getElementById('anneeValues'), '');
  updateSliderValues(prixSlider, document.getElementById('prixValues'), '€');
  // Attachez un événement pour mettre à jour la liste des véhicules lorsque les sliders changent
  kilometrageSlider.noUiSlider.on('change', updateVehicleList);
  anneeSlider.noUiSlider.on('change', updateVehicleList);
  prixSlider.noUiSlider.on('change', updateVehicleList);

  // Chargez la liste initiale des véhicules lors du chargement de la page
  updateVehicleList();
});
