<template>
    <div>
        <b-form class="mt-5" @submit.prevent="mode === 'save' ? save() : atualizar()">
            <div role="tablist">
                <b-card no-body class="mb-1">
                    <b-card-header header-tag="header" class="p-1" role="tab">
                        <b-button block href="#" v-b-toggle.accordion-1 variant="info">
                            Formulário de Vendas
                            <i class="right fas fa-arrow-down"></i>
                        </b-button>
                    </b-card-header>
                    <b-collapse id="accordion-1" visible accordion="my-accordion" role="tabpanel">
                        <b-card-body>
                            <b-row>
                                <b-col md="12" sm="12">
                                    <b-form-group label="Arquivo Anexado:" label-for="vendas-contato">
                                        <b-form-file name="contrato" id="vendas-contrato" v-model="vendas.contrato"
                                            placeholder="Selecione um arquivo..." @change="updateFile"></b-form-file>
                                        <span v-if="errors && errors.arquivo" class="text-danger">{{
                                                errors.arquivo[0]
                                        }}</span>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-card-body>
                    </b-collapse>
                </b-card>
            </div>

            <b-col xs="12" class="mt-2">
                <b-button type="submit" variant="primary" v-if="mode === 'save'">Salvar</b-button>
                <b-button class="ml-2" @click="reset">Cancelar</b-button>
            </b-col>
        </b-form>
        <hr />

        <b-card border-variant="info" header="LISTA DE VENDAS" header-bg-variant="info" header-text-variant="white"
            align="center" class="mb-1">


            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <b-table responsive="sm" hover striped fixed bordered :sort-by.sync="sortBy" :sort-desc.sync="sortDesc"
                    :filter="filter" :busy.sync="isBusy" :items="venda" :fields="fields" :current-page="currentPage"
                    :per-page="perPage" @filtered="onFiltered">
                    <template v-slot:cell(actions)="data">
                        <b-button pill variant="outline-danger" @click="deleteVenda(data.item.id)">
                            <b-icon icon="trash-fill" aria-hidden="true"></b-icon>
                            Excluir
                        </b-button>
                    </template>
                    <template v-slot:table-busy>
                        <div class="text-center text-danger my-2">
                            <b-spinner class="align-middle"></b-spinner>
                            <strong>Carregando...</strong>
                        </div>
                    </template>
                </b-table>
                <div class="card-footer">
                    <b-col sm="7" md="6" class="my-1">
                        <b-pagination v-model="currentPage" :total-rows="totalRows" :per-page="perPage" align="fill"
                            size="sm" class="my-0"></b-pagination>
                    </b-col>
                </div>
            </div>
        </b-card>
    </div>
</template>

<script>
import { Money } from "v-money";

export default {
    components: {
        Money,
    },

    data: function () {
        return {
            money: {
                decimal: ",",
                thousands: ".",
                prefix: "R$ ",
                precision: 2,
                masked: false,
            },
            mode: "save",
            vendas: {
                contrato: null,
                arquivo: "",
                flagArquivo: false,
                vendas: {}
            },
            venda: [],
            success: true,
            isBusy: false,
            action: "api/formulario-vendas",
            filter: null,
            perPage: 5,
            pageOptions: [5, 10, 15],
            totalRows: 1,
            currentPage: 1,
            errors: {},
            sortBy: "nome_comprador",
            sortDesc: false,
            fields: [
                {
                    key: "comprador",
                    label: "Comprador",
                    sortable: true,
                    formatter: (value) =>
                        value === "" || value === null
                            ? "Não se aplica"
                            : value.toUpperCase(),
                },

                {
                    key: "descricao",
                    label: "Descrição",
                    sortable: true,
                    formatter: (value) =>
                        value === "" || value === null
                            ? "Não se aplica"
                            : value.toUpperCase(),
                },

                {
                    key: "preco_unitario",
                    label: "Preço Unitário",
                    sortable: true,
                    formatter: (value) =>
                        value == null ? "Não se aplica" : this.formatarDinheiro(value),
                },


                {
                    key: "quantidade",
                    label: "Quantidade",
                    sortable: true
                },
                {
                    key: "endereco",
                    label: "Endereço",
                    sortable: true,
                    formatter: (value) =>
                        value === "" || value === null
                            ? "Não se aplica"
                            : value.toUpperCase(),
                },

                {
                    key: "fornecedor",
                    label: "Fornecedor",
                    sortable: true,
                    formatter: (value) =>
                        value === "" || value === null
                            ? "Não se aplica"
                            : value.toUpperCase(),
                },

                { key: "actions", label: "Ações" },
            ],
        };
    },

    methods: {
        formatarDinheiro(value) {
            var formatter = new Intl.NumberFormat("pt-BR", {
                style: "currency",
                currency: "BRL",
            });

            return formatter.format(value);
        },

        onFiltered(filteredItems) {
            this.totalRows = filteredItems.length;
            this.currentPage = 1;
        },

        updateFile(e) {
            let file = e.target.files[0];
            let reader = new FileReader();
            (this.vendas.flagArquivo = true),
                (reader.onloadend = (file) => {
                    this.vendas.arquivo = reader.result;
                });
            reader.readAsDataURL(file);
        },

        reset() {
            this.mode = "save";
            (this.vendas = {
                contrato: null,
                arquivo: "",
                flagArquivo: false,
                vendas: {}
            }),

                this.loadVendas();

        },
        toggleBusy() {
            this.isBusy = !this.isBusy;
        },
        save() {

            this.$Progress.start();
            this.success = false;
            (this.errors = {}),
                axios
                    .post(this.action, this.vendas)
                    .then((response) => {
                        this.success = true;
                        this.$toasted.global.defaultSuccess({
                            msg: "Venda cadastrada com sucesso!",
                        });
                        //this.venda = response.data.data.vendas;
                        this.reset();
                        this.$Progress.finish();
                    })
                    .catch((error) => {
                        this.loaded = true;
                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors;
                        }
                        Toast.fire({
                            icon: "error",
                            title: "Ops Houve Um Problema No Formulário, Tente Novamente!",
                        });

                        this.$Progress.fail();
                    });
        },
        loadVendas() {
            axios
                .get(this.action)
                .then(
                    (res) => (
                        (this.venda = res.data), (this.totalRows = res.data.length)
                    )
                );
        },

        deleteVenda(id) {
            swal
                .fire({
                    title: "você tem certeza?",
                    text: "Está ação não poderá ser revertida!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sim, deletar!",
                    cancelButtonText: "Cancelar!",
                })
                .then((result) => {
                    if (result.value) {
                        axios
                            .delete("api/formulario-vendas/" + id)
                            .then((response) => {
                                swal.fire(
                                    "Deletado!",
                                    "Venda deletada com sucesso!",
                                    "success"
                                );
                                this.loadVendas();
                            })
                            .catch((error) => {
                                swal.fire("Falha!", "Problema ao deletar vendas", "error");
                            });
                    }
                });
        },

        loadVendasModo(vendas, mode = "atualizar") {
            this.mode = mode;
            (vendas.flagArquivo = false), (this.vendas = { ...vendas });
        },

    },
    mounted() {
        this.loadVendas();
    },
};
</script>

<style>
.money {
    display: block;
    width: 100%;
    height: calc(1.5em + 0.75rem + 2px);
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
</style>
