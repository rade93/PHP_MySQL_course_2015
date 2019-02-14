				<div class="row"> <!--Footer-->
					<div class="col col-md-2 col-md-offset-5 ">
						<p class="text-muted" style="margin-top: 180px;">&copy; PHP Course 2016</p>
					</div>
				</div>

				<script src="http://maps.googleapis.com/maps/api/js"></script>
				<script>

					<?php
						//Dohvatanje podataka o geo sirini i duzini,a ako nema nista u tom nizu dajemo jednu defaul vrijednost
						$latitude = (isset($data)) ? $data[0] : 44.76666670;
						$longitude = (isset($data)) ? $data[1] : 17.18333330;
						$formated_address = (isset($data)) ? $data[2] : 'Banja Luka';
					?>

					//Smijestanje podatka iz PHP $data niza u JavaScript varjable radi upotrebe u initialize() funk.
					var latitude = <?=$latitude?>;
					var longitude = <?=$longitude?>;
					var address = '<?=$formated_address?>';

					function initialize() {
						var mapProp = {
							center:new google.maps.LatLng(latitude, longitude),
							zoom:14,
							mapTypeId:google.maps.MapTypeId.ROADMAP
						};
						var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

						var myCenter=new google.maps.LatLng(latitude, longitude);
						var marker=new google.maps.Marker({
						  	position:myCenter
						  });

						marker.setMap(map);

						infowindow = new google.maps.InfoWindow({
							content: address,
						});

						google.maps.event.addListener(marker, "click", function () {
							infowindow.open(map, marker);
						});

						infowindow.open(map, marker);

						// Zoom to 9 when clicking on marker
						google.maps.event.addListener(marker,'click',function() {
							map.setZoom(16);
							map.setCenter(marker.getPosition(latitude, longitude));
						});
					}

					google.maps.event.addDomListener(window, 'load', initialize);
				
				</script>
			</div>
		</div>
	</body>
</html>