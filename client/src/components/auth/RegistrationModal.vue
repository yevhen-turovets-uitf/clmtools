<template>
  <div
    v-show="show_modal"
    class="modal bg-dark bg-opacity-40"
    tabindex="-1"
    role="dialog"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ $t("auth.confirm_email") }}</h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            @click="Close"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>
            {{ $t("auth.please_confirm_email") }}
          </p>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-dismiss="modal"
            @click="reSend"
          >
            {{ $t("auth.resend") }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
  name: 'RegistrationModal',

  data: () => ({
    show_modal: false
  }),

  computed: {
    ...mapGetters('auth', {
      registered_user_id: 'getRegistrationUserId'
    })
  },

  methods: {
    ...mapActions('auth', ['RESEND_VERIFY_EMAIL']),
    ...mapActions([
      'makeAlert'
    ]),
    reSend() {
      this.RESEND_VERIFY_EMAIL({ id: this.registered_user_id.id })
        .then(() => {
            this.makeAlert(this.$t("auth.resended"));
        })
        .catch(error => {
          if (error.message) {
              this.makeAlert(error.message);
          }
        });
    },
    showModal() {
      this.show_modal = true;
    },
    Close() {
      this.show_modal = false;
    }
  }
};
</script>

<style>
.modal {
  display: block;
}
</style>
