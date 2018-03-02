import ally from 'ally.js/ally';

/**
 * Custom JavaScript functions.
 *
 * @version 2.0.3
 *
 * @package Fanoe
 */
{
	/**
	 * Get the html element.
	 *
	 * @type {Element}
	 */
	const root = document.documentElement;

	/**
	 * Remove the no-js class
	 */
	root.removeAttribute('class', 'no-js');

	/**
	 * Set a js class.
	 */
	root.setAttribute('class', 'js');

	/**
	 * Get the elements for sidebar handling.
	 */
	const openButton = document.querySelector('.sidebar-button.-open');
	const closeButton = document.querySelector('.sidebar-button.-close');
	const sidebarElem = document.querySelector('.sidebar');
	let disabledHandle;
	let tabHandle;
	let keyHandle;

	/**
	 * Call sidebar function sidebar button click.
	 */
	openButton.addEventListener('click', sidebar, false);

	/**
	 * Call sidebar function sidebar button click.
	 */
	closeButton.addEventListener('click', sidebar, false);

	/**
	 * Catch clicks on the document to close sidebar on mouse click
	 * outside the open sidebar.
	 */
	document.body.addEventListener('click', function (e) {
		/**
		 * Check if the sidebar is visible.
		 */
		if (root.classList.contains('active-sidebar')) {
			/**
			 * Check if the click was made on the .sidebar element, not the .sidebar-content.
			 */
			if (e.explicitOriginalTarget.classList.contains('sidebar')) {
				disabledHandle.disengage();
				tabHandle.disengage();
				root.classList.remove('active-sidebar');
			}
		}
	}, false);

	addClassToImageLinks();

	/**
	 * Function to display and hide sidebar.
	 *
	 * @link https://allyjs.io/tutorials/accessible-dialog.html
	 */
	function sidebar() {
		/**
		 * Toggle .active-sidebar class.
		 */
		root.classList.toggle('active-sidebar');

		/**
		 * Check for class name to know if the
		 * sidebar is currently visible or not.
		 */
		if (root.classList.contains('active-sidebar')) {
			setTimeout(function() {
				disabledHandle = ally.maintain.disabled({
					filter: sidebarElem,
				});

				tabHandle = ally.maintain.tabFocus({
					context: sidebarElem,
				});

				keyHandle = ally.when.key({
					escape: sidebar,
				});
			});
		} else {
			disabledHandle.disengage();
			tabHandle.disengage();
			keyHandle.disengage();
		}
	}

	function addClassToImageLinks() {
		/**
		 * Get the images which live inside a link.
		 *
		 * @type {NodeList}
		 */
		const linked_images = document.querySelectorAll('a > img');

		/**
		 * Loop through the images and add a class.
		 */
		for (let i = 0; i < linked_images.length; i++) {
			if ('img-link' === linked_images[i].parentElement.className) {
			} else {
				linked_images[i].parentElement.classList.add('img-link');
				if (linked_images[i].parentElement.parentElement.children.length === 1) {
					linked_images[i].parentElement.parentElement.classList.add('img-link-wrapper');
				}
			}
		}
	}
}
