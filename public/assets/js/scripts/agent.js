import { get, postJson, post } from "../main/http.js";
import Select2 from "../components/select2Component.js";

new Vue({
    el: "#AppAgent",
    components: {
        Select2,
    },
    data() {
        return {
            error: null,
            result: null,
            isLoading: false,
            isDataLoading: false,
            agents: [],
            appro: {
                purchase_id: "",
                pa: "",
                qty: "",
                date: "",
                supplier: "",
                pu: "",
            },
            form: {
                product_id: "",
                name: "",
                category_id: "",
                unit_price: "",
                purchase: {
                    quantity: "",
                    unit_price: "",
                    supplier_name: "",
                    date: "",
                },
            },
            search: "",
            byDate: "",
            load_id: "",
        };
    },
    mounted() {
        const self = this;
        if ($("#agent-modal").length) {
            let myModal = document.getElementById("agent-modal");
            // Add an event listener for the 'hidden.bs.modal' event
            myModal.addEventListener("hidden.bs.modal", function (event) {
                self.clearFields();
            });
        }

        this.$nextTick(() => {
            this.viewAllAgents();
        });
    },
    methods: {
        viewAllAgents() {
            this.isDataLoading = true;
            get("/agents.all")
                .then((res) => {
                    this.isDataLoading = false;
                    this.agents = res.data.agents;
                })
                .catch((err) => {
                    console.log("error", err);
                    this.isDataLoading = false;
                });
        },
        submitForm(event) {
            const formData = new FormData();
            formData.append("product_id", this.form.product_id);
            formData.append("name", this.form.name);
            formData.append("category_id", this.form.category_id);
            formData.append("unit_price", this.form.unit_price);
            formData.append(
                "stock_supplier_name",
                this.form.purchase.supplier_name
            );
            formData.append("stock_quantity", this.form.purchase.quantity);
            formData.append("stock_unit_price", this.form.purchase.unit_price);
            formData.append("stock_date", this.form.purchase.date);
            this.isLoading = true;

            post("/product.create", formData)
                .then(({ data, status }) => {
                    this.isLoading = false;
                    if (data.errors !== undefined) {
                        this.error = data.errors;
                    }
                    if (data.result !== undefined) {
                        this.error = null;
                        this.viewAllProducts();
                        this.clearFields();

                        new Swal({
                            title: data.result,
                            icon: "success",
                            showConfirmButton: !1,
                            timer: 3000,
                        });
                    }
                })
                .catch((err) => {
                    this.isLoading = false;
                    this.error = err;
                    console.error(err);
                });
        },

        triggerEdit(data) {
            this.form.product_id = data.id;
            this.form.name = data.name;
            this.form.unit_price = data.unit_price;
            this.form.category_id = data.category_id;
        },

        editAppro(data) {
            this.selectedAppro = data;
            this.appro.purchase_id = data.id;
            this.appro.pa = data.unit_price;
            this.appro.qty = data.quantity;
            this.appro.supplier = data.supplier_name;
        },

        clearFields() {
            this.form = {
                product_id: "",
                name: "",
                category_id: "",
                unit_price: "",
                purchase: {
                    quantity: "",
                    unit_price: "",
                    supplier_name: "",
                    date: "",
                },
            };
        },

        deleteAgent(id) {
            let self = this;
            new Swal({
                title: "Attention! Action irréversible.",
                text: "La suppression du produit entraine la suppression de tous les mouvements liés à ce produit ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Confirmer",
                cancelButtonText: "Annuler",
            }).then((result) => {
                if (result.isConfirmed) {
                    self.load_id = id;
                    postJson("/data.delete", {
                        table: "products",
                        id: id,
                        id_field: "id",
                    })
                        .then((res) => {
                            self.load_id = "";
                            self.viewAllProducts();
                        })
                        .catch((err) => {
                            self.load_id = "";
                        });
                }
            });
        },

        downloadExportPdf() {
            location.href = `/purchases.reports.export?date=${this.byDate}`;
        },
    },

    computed: {
        filteredAgents() {
            if (this.search && this.search.trim()) {
                return this.agents.filter((el) =>
                    el.nom
                        .toLowerCase()
                        .includes(
                            this.search.toLowerCase() ||
                                el.matricule.this.search
                                    .toLowerCase()
                                    .includes(this.search.toLowerCase())
                        )
                );
            } else {
                return this.agents;
            }
        },
    },
});
