//souris sur les éléments
$(".voting_stars").mouseover(function() {
	let $this = $(this);

	$this.prevAll().addBack().attr("src","images/stars/star_highlight.png") //changer d'image pour toutes les étoiles jusqu'à celle actuellement survolée
});


//souris click les éléments
star_number = $(".voting_stars").click(function() {
	let $this = $(this);
	//on enregistre le numéro de l'étoile clickée (pour enregistrer le vote)
	let id = $this.attr("id")
	star_number = id.substr(id.length - 1);

	$("#hiddenvote").attr("value", star_number);//on écrit le numéro dans le form de vote

	$this.prevAll().addBack().attr("src","images/stars/star_full.png")
	$this.nextAll().attr("src", "images/stars/star_empty.png");
});


//souris quitte les éléments
$(".voting_stars").mouseout(function() {
	let $this = $(this);

	//autrement dit, est-ce que l'utilisateur a déjà voté
	if (star_number > 0) {
		let id_star = "#vote" + star_number;
		$(id_star).prevAll().addBack().attr("src", "images/stars/star_full.png");
		$(id_star).nextAll().attr("src", "images/stars/star_empty.png");
	}
	//sinon il n'a toujours pas fait son choix
	else {
		$this.prevAll().addBack().attr("src", "images/stars/star_empty.png");
	}

});