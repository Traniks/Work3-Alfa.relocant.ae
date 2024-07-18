document.addEventListener('DOMContentLoaded', () => {
    const items = document.querySelectorAll('.services__item')
	const modal = document.getElementById('modal-services')
	const modalTitle = modal.querySelector('#modal-services .modal-messengers__content-title span')
	// console.log(modalTitle)

    const titles = [
		'"Поддержка в получении водительских прав"',
		'"Консультации по открытию бизнеса"',
		'"Бухгалтерские и налоговые услуги"',
		'"Аренда и покупка недвижимости"',
		'"Регистрация детей в образовательные учреждения"',
		'"Медицинское обслуживание и страхование"',
		'"Перевод и легализация документов"',
	]

	items.forEach(item => {
		item.addEventListener('click', () => {
			// console.log(item);
			const position = item.getAttribute('data-position')
			// console.log(position)
			modalTitle.textContent = titles[position - 1]
		})
	})

	const cross = document.getElementById('modal-services__cross')

	cross.addEventListener('click', () => {
		modal.classList.remove('modal-messengers_active') // Убирает класс - закрывает модалку
		document.body.style.overflow = '' // Восстанавливает прокрутку сайта
	})

});