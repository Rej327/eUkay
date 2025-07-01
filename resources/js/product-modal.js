import { useToast } from './modules/toast.js';
import { useModal } from './modules/modal.js';
import { useSort } from './modules/sort.js';
import { useSearch } from './modules/search.js';

export default function () {
  const products = window.initialProducts || [];
  const routeStore = window.routeStore || '';

  return {
    routeStore,

    ...useToast(),
    ...useModal(),
    ...useSort(),
    ...useSearch(products),

    deleteConfirm: {
      show: false,
      id: null,
    },

    confirmDelete(id) {
      this.deleteConfirm = {
        show: true,
        id,
      };
    },

    openServerErrorModal(oldValues, validationErrors = {}) {
        this.modalOpen = true;
        this.isEdit = oldValues.is_edit === '1';

        this.form = {
            id: oldValues.id || null,
            name: oldValues.name || '',
            price: oldValues.price || '',
            stock: oldValues.stock || '',
            description: oldValues.description || '',
            category_id: oldValues.category_id || '',
            image_url: oldValues.image_url || null,
        };

        this.errors = validationErrors || {};
    },

    get sortedProducts() {
      const sorted = [...this.filteredProducts];
      const key = this.sortBy;
      const dir = this.sortDir;

      return sorted.sort((a, b) => {
        let valA = a[key], valB = b[key];
        if (typeof valA === 'string') valA = valA.toLowerCase();
        if (typeof valB === 'string') valB = valB.toLowerCase();

        if (valA < valB) return dir === 'asc' ? -1 : 1;
        if (valA > valB) return dir === 'asc' ? 1 : -1;
        return 0;
      });
    },
  };
}
