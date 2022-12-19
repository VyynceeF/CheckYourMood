function myFunction() {
    var x = document.getElementById("myInput");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
}

const data = {
  labels: [
    'Samedi',
    'Dimanche',
    'Lundi',
    'Mardi',
    'Mercredi',
    'Jeudi',
    'Vendredi'
  ],
  datasets: [{
    label: document.getElementById('humeur').options[document.getElementById('humeur').selectedIndex].text,
    data: dataHumeur,
    fill: true,
    backgroundColor: 'rgba(255, 99, 132, 0.2)',
    borderColor: 'rgb(255, 99, 132)',
    pointBackgroundColor: 'rgb(255, 99, 132)',
    pointBorderColor: '#fff',
    pointHoverBackgroundColor: '#fff',
    pointHoverBorderColor: 'rgb(255, 99, 132)'
  }]
};

//Création du diagramme pour afficher les
const ctx = document.getElementById('myChart');
new Chart(ctx, {
  type: 'radar',
data: data,
options: {
  elements: {
    line: {
      borderWidth: 3
     }
   }
  },
});


  
















  