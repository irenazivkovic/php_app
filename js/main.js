
function prikazi() {
    var x = document.getElementById("pregled");
    if (x.style.display === "none") {
      x.style.display = "block";
    } else {
      x.style.display = "none";
    }
  } 


$('#btn-izbrisi').click( function(){
  const checked = $('input[name="checked-donut"]:checked');
  
  request = $.ajax({
    url:'crud/delete.php',
    type: 'post',
    data: {'id': checked.val()}
  });
  request.done(function (response, textStatus, jqXHR) {
    if (response === 'Success') {
      $('div#container').children(`#${checked.val()}`).remove();
      console.log('Pregled je obrisan ');
      alert('Pregled je obrisan');

    }
    else {
      console.log('Pregled nije obrisan ' + response);
      alert('Pregled nije obrisan');
    }
});

});
 
$('#btnDodaj').submit(function(){
    $('myModal').modal('toggle');
    return false;
});

$('#dodajForm').submit(function (event) {
    event.preventDefault();
  
    const $zubar = $('input[name="zubar"]').val();
    const $grad = $('input[name="grad"]').val();
    const $kategorija = $('input[name="kategorija"]').val();
    const $datum = $('input[name="datum"]').val();
    
    request = $.ajax({
        url: 'crud/add.php',
        type: 'post',
        data: {
          'zubar': $zubar,
          'grad': $grad,
          'kategorija': $kategorija,
          'datum': $datum,
          'user_id': localStorage.getItem('UserID')
        }
    });

    request.done(function (response, textStatus, jqXHR) {
        if (response === 'Success') {
            alert('Pregled je dodat');
            $.get("crud/getLastElement.php", function (data){
              
              const split = data.split('"');
              data = [];
              split.forEach((element) => {
                  if(element != '[' && element != ',' && element != ']'){
                      data.push(element);
                  };
              });

              $('#container').append(`
                <div class="card text-white bg-info mb-6" id=${data[0]} style="width:15%; position: static; border-radius: 20px; text-align: center; margin: 30px 30px;">       
                  <div class="card-header">
                    <h3><b>Zakazan pregled</b></h3>
                  </div>
                  <div class="card-body">
                    <ul style="list-style: none;">
                      <li>Zubar: ${data[1]}</li>
                      <li>Grad: ${data[2]}</li>
                      <li>Kategorija: ${data[3]}</li>
                      <li>Datum: ${data[4]}</li>
                      <li>
                        <label class="radio-btn">
                          <input type="radio" name="checked-donut" value=${data[0]}>
                          <span class="checkmark"></span>
                        </label>
                      </li>
                    </ul>
                  </div>
                </div>
              `);
            });
        }
        else console.log('Pregled nije dodat ' + response);
        console.log(response);
    });

    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error('The following error occurred: ' + textStatus, errorThrown);
    });
});

