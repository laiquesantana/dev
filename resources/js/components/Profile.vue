<style >
.widget-user {
  height: 400px;
}
.widget-user .widget-user-header {
  background-position: center center;
  background-size: cover;
  height: 400px;
}
.widget-user .card-footer {
  padding: 0;
}
</style>


<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-widget widget-user mt-5">
          <!-- Add the bg color to the header using any of the bg-* classes -->
          <div
            class="widget-user-header text-white"
            style="background-image:url('./img/user-cover.jpg')"
          >
            <h3 class="widget-user-username text-left">{{this.fields.name }}</h3>
          </div>
          <div class="widget-user-image">
            <img class="img-circle" :src="getProfilePhoto()" alt="User Avatar" />
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <h5 class="description-header">{{this.fields.created_at | formatData}}</h5>
                  <span class="description-text">Data de Criação</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <h5 class="description-header">{{this.fields.updated_at | formatData}}</h5>
                  <span class="description-text">Ultima Atualização</span>
                </div>
                <!-- /.description-block -->
              </div>
            </div>
            <!-- /.row -->
          </div>
        </div>
        <!-- tab -->
        <b-tabs content-class="mt-3">
        <div class="card">
          <!-- /.card-header -->
          <div class="card-body">
            <div>

                <b-tab title="Dados Pessoais" active>
                    <div class="tab-pane active show" id="settings">
                <form @submit.prevent="updateUser()" class="form-horizontal">
                  <div class="modal-body">
                    <div class="form-group">
                      <label for="name">Nome</label>
                      <input
                        type="text"
                        class="form-control"
                        name="name"
                        id="name"
                        v-model="fields.name"
                        required
                      />
                      <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
                    </div>

                    <div class="form-group">
                      <label for="cpf">CPF</label>
                      <input
                        type="tel"
                        class="form-control"
                        name="cpf"
                        id="cpf"
                        v-mask="'###.###.###-##'"
                        v-model="fields.cpf"
                        required
                      />
                      <div v-if="errors && errors.cpf" class="text-danger">{{ errors.cpf[0] }}</div>
                    </div>

                    <div class="form-group">
                      <label for="email">E-mail</label>
                      <input
                        type="email"
                        class="form-control"
                        name="email"
                        id="email"
                        v-model="fields.email"
                        required
                      />
                      <div v-if="errors && errors.email" class="text-danger">{{ errors.email[0] }}</div>
                    </div>

                    <div class="form-group">
                      <label for="photo">Foto do Perfil</label>
                      <input
                        type="file"
                        class="form-control"
                        name="photo"
                        id="photo"
                        @change="updatePhotoProfile"
                      />
                      <div v-if="errors && errors.photo" class="text-danger">{{ errors.photo[0] }}</div>
                    </div>

                    <div class="form-group">
                      <button type="submit" class="btn btn-success">
                        Atualizar Usuário
                        <i class="fas fa-user-edit"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>

                </b-tab>
                <b-tab title="Alterar senha">  <div class="tab-pane" id="activity">
                <form @submit.prevent="updateUserPassword()" class="form-horizontal">
                  <div class="form-group">
                    <label for="password">Senha Atual</label>
                    <input
                      type="password"
                      class="form-control"
                      name="senha_atual"
                      autocomplete="senha_atual"
                      id="senha_atual"
                      required
                      v-model="PasswordFields.senha_atual"
                    />
                    <div
                      v-if="errors && errors.senha_atual"
                      class="text-danger"
                    >{{ errors.senha_atual[0] }}</div>
                  </div>
                  <div class="form-group">
                    <label for="password">Nova senha</label>
                    <input
                      type="password"
                      class="form-control"
                      name="nova_senha"
                      autocomplete="senha_atual"
                      id="nova_senha"
                      required
                      v-model="PasswordFields.nova_senha"
                    />
                    <div
                      v-if="errors && errors.nova_senha"
                      class="text-danger"
                    >{{ errors.nova_senha[0] }}</div>
                  </div>
                  <div class="form-group">
                    <label for="password">Confirme a nova senha</label>
                    <input
                      type="password"
                      class="form-control"
                      name="nova_senha_confirmada"
                      autocomplete="senha_atual"
                      id="nova_senha_confirmada"
                      required
                      v-model="PasswordFields.nova_senha_confirmada"
                    />
                    <div
                      v-if="errors && errors.nova_senha_confirmada"
                      class="text-danger"
                    >{{ errors.nova_senha_confirmada[0] }}</div>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-success">
                      Atualizar Senha
                      <i class="fas fa-user-edit"></i>
                    </button>
                  </div>
                </form>
              </div></b-tab>

            </div>
            <div class="tab-content">
              <!-- Setting Tab -->

              <!-- Password Tab -->

              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.card-body -->
        </div>
    </b-tabs>
        <!-- /.nav-tabs-custom -->
        <!-- end tabs -->
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      photoChanged: false,
      fields: {},
      errors: {},
      PasswordFields: {},
      success: false,
      loaded: true
    };
  },
  mounted() {},

  created() {
    this.loadProfile();
  },

  methods: {
    getProfilePhoto() {
      if (!this.photoChanged) {
        return "img/profile/" + this.fields.photo;
      } else {
        return this.fields.photo;
      }
    },
    loadProfile() {
      this.$Progress.start();
      axios
        .get("api/profile")
        .then(({ data }) => (this.fields = data), this.$Progress.finish())
        .catch(error => {
          Toast.fire({
            icon: "error",
            title: "Falha Ao Carregar Perfil Do Usuário!"
          }),
            this.$Progress.fail();
        });
    },
    updateUser() {
      if (this.loaded) {
        this.$Progress.start();
        this.loaded = true;
        this.success = false;
        this.errors = {};
        if (this.fields.password == "") {
          this.fields.password = undefined;
        }
        axios
          .put("api/profile/", this.fields)
          .then(response => {
            this.loaded = true;
            this.success = true;
            Toast.fire({
              icon: "success",
              title: "Perfil Atualizado com Sucesso !"
            });
            this.$Progress.finish();
          })
          .catch(error => {
            this.loaded = true;
            this.success = false;
            if (error.response.status === 422) {
              this.errors = error.response.data.errors || {};
            }
            Toast.fire({
              icon: "error",
              title: "Ops Houve Um Problema No Formulário, Tente Novamente!"
            });

            this.$Progress.fail();
          });
      }
    },
    updateUserPassword() {
      if (this.loaded) {
        this.$Progress.start();
        this.loaded = true;
        this.success = false;
        this.errors = {};
        axios
          .post("api/change-password/", this.PasswordFields)
          .then(response => {
            this.loaded = true;
            this.success = true;
            Toast.fire({
              icon: "success",
              title: "Senha Atualizada com Sucesso !"
            });
            (this.PasswordFields = {}), this.$Progress.finish();
          })
          .catch(error => {
            this.loaded = true;
            this.success = false;
            if (error.response.status === 422) {
              this.errors = error.response.data.errors || {};
            }
            Toast.fire({
              icon: "error",
              title: "Ops Houve Um Problema No Formulário, Tente Novamente!"
            });

            this.$Progress.fail();
          });
      }
    },
    updatePhotoProfile(e) {
      let file = e.target.files[0];
      let reader = new FileReader();
      let limit = 1024 * 1024 * 2;

      if (file["size"] > limit) {
        swal.fire({
          icon: "error",
          title: "Tamanho da imagem acima do permitido!"
        });
        return false;
      }
      reader.onloadend = file => {
        this.fields.photo = reader.result;
      };
      reader.readAsDataURL(file);
      this.photoChanged = true;
    }
  }
};
</script>


