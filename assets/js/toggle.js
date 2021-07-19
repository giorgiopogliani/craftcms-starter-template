import Alpine from 'alpinejs';

Alpine.data('toggle', (defaultIsOpen = false) => {
  return {
    isOpen: defaultIsOpen,
    open() {
      this.isOpen = true;
    },
    close() {
      this.isOpen = false;
    },
    toggle() {
      this.isOpen = !this.isOpen;
    }
  }
})