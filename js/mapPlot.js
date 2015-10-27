	function myFunction()
	{
		var myLat = document.getElementById("coordslat").innerHTML;
		var myLon = document.getElementById("coordslon").innerHTML;

		var myLat2 = document.getElementById("coordslat2").innerHTML;
		var myLon2 = document.getElementById("coordslon2").innerHTML;

		var myLat3 = document.getElementById("coordslat3").innerHTML;
		var myLon3 = document.getElementById("coordslon3").innerHTML;


	//	alert(myInnerHtml);

	// var img_url = "http://maps.googleapis.com/maps/api/staticmap?center="+myInnerHtml+"&zoom=14&size=400x300&sensor=false";
	//document.getElementById("mapholder").innerHTML = "<img src='"+img_url+"'>"

	var mapcanvas = document.createElement('div');
	mapcanvas.id = 'mapcontainer';
	mapcanvas.style.height = '600px';
	mapcanvas.style.width = '100%';

	document.querySelector('article').appendChild(mapcanvas);

	var coords = new google.maps.LatLng(myLat, myLon);
	var coords2 = new google.maps.LatLng(myLat2, myLon2);
	var coords3 = new google.maps.LatLng(myLat3, myLon3);


	var options = {
		zoom: 15,
		center: coords,
		mapTypeControl: false,
		navigationControlOptions: {
			style: google.maps.NavigationControlStyle.SMALL
		},
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	var map = new google.maps.Map(document.getElementById("mapcontainer"), options);

	var time = $('#time_posted').html();
	var time2 = $('#time_posted2').html();
	var time3 = $('#time_posted3').html();


	var marker = new google.maps.Marker({
		position: coords,
		map: map,
		title: time
	});

	var marker2 = new google.maps.Marker({
		position: coords2,
		map: map,
		title: time2
	});

	var marker3 = new google.maps.Marker({
		position: coords3,
		map: map,
		title: time3
	});
}
