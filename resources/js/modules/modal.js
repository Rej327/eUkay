export function useModal() {
    return {
        modalOpen: false,
        isEdit: false,
        routeUpdate: "",
        form: {
            id: null,
            name: "",
            price: "",
            stock: "",
            description: "",
            category_id: "",
        },

        openAddModal() {
            this.isEdit = false;
            this.modalOpen = true;
            this.form = {
                id: null,
                name: "",
                price: "",
                stock: "",
                description: "",
                category_id: "",
            };
            this.routeUpdate = "";
        },

        openEditModal(product) {
            this.isEdit = true;
            this.modalOpen = true;
            this.form = {
                ...product,
                image_url: product.images?.length
                    ? `/storage/${product.images[0].image_path}`
                    : null,
            };
            this.routeUpdate = `/manage-products/${product.id}`;
        },

        closeModal() {
            this.modalOpen = false;
            this.isEdit = false;

            this.form = {
                id: null,
                name: "",
                price: "",
                stock: "",
                description: "",
                category_id: "",
                image_url: null,
            };

            this.errors = {
                name: [],
                price: [],
                stock: [],
                description: [],
                category_id: [],
                image: [],
            };

            const fileInput = document.getElementById("image");
            if (fileInput) fileInput.value = "";
        },

        openServerErrorModal(oldValues, errors) {
            this.modalOpen = true;
            this.isEdit = false;
            this.form = {
                ...this.form,
                ...oldValues,
            };

            this.errors = {
                name: errors.name || [],
                price: errors.price || [],
                stock: errors.stock || [],
                description: errors.description || [],
                category_id: errors.category_id || [],
                image: errors.image || [],
            };
        },
    };
}
