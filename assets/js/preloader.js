document.addEventListener('DOMContentLoaded', function () {
	const preloader = document.getElementById('preloader')
	const percentsElement = document.getElementById('percents')
	const content = document.getElementById('content')

	let images = document.images
	let imagesTotalCount = images.length
	let imagesLoadedCount = 0

	for (let i = 0; i < imagesTotalCount; i++) {
		let img = new Image()
		img.onload = imageLoaded
		img.onerror = imageLoaded
		img.src = images[i].src
	}

	function imageLoaded() {
		imagesLoadedCount++
		let percents = ((100 / imagesTotalCount) * imagesLoadedCount) << 0
		percentsElement.textContent = percents

		if (imagesLoadedCount >= imagesTotalCount) {
			setTimeout(function () {
				preloader.style.display = 'none'
			}, 500) 
		}
	}
})
