export function useModal() {
  return {
    modalOpen: false,
    isEdit: false,
    routeUpdate: '',
    form: {
      id: null,
      name: '',
      price: '',
      stock: '',
      description: '',
      category_id: ''
    },

    openAddModal() {
      this.isEdit = false;
      this.modalOpen = true;
      this.form = {
        id: null,
        name: '',
        price: '',
        stock: '',
        description: '',
        category_id: ''
      };
      this.routeUpdate = '';
    },

    openEditModal(product) {
      this.isEdit = true;
      this.modalOpen = true;
      this.form = {
        ...product,
        image_url: product.images?.length ? `/storage/${product.images[0].image_path}` : null
      };
      this.routeUpdate = `/manage-products/${product.id}`;
    },

    closeModal() {
      this.modalOpen = false;
    }
  };
}
