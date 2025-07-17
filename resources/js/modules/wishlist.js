export function wishlistApp() {
    return {
        deleteConfirm: {
            show: false,
            productId: null,
        },
        serverError: {
            show: false,
            errors: {},
        },
        toast: {
            show: false,
            message: "",
        },
        confirmDelete(id) {
            this.deleteConfirm.productId = id;
            this.deleteConfirm.show = true;
        },
        showToast(message) {
            this.toast.message = message;
            this.toast.show = true;
            setTimeout(() => (this.toast.show = false), 3000);
        },
        openServerErrorModal(oldValues, validationErrors) {
            this.serverError.errors = validationErrors;
            this.serverError.show = true;
        },
        init() {
            if (window.successMessage) {
                this.showToast(window.successMessage);
            }
            if (window.validationErrors && window.oldValues) {
                this.openServerErrorModal(
                    window.oldValues,
                    window.validationErrors
                );
            }
        },
    };
}
