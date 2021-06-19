<template>
  <div>
    <transition name="modal" @close="showModal = false">
      <div class="modal-mask">
        <div class="modal-wrapper">

          <div class="modal-body">
            <slot name="body">

              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" v-on:click="$emit('close')">
                  <span aria-hidden="true">&times;</span>
                </button>
                <div v-for="(v, k) in errors" :key="k">
                  <p v-for="error in v" :key="error" class="text-sm">
                    {{ error }}
                  </p>
                </div>
              </div>
            </slot>

          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
export default {
    name: 'modal',
    props: {
        errors: {
            type: Object,
            required: false,
            default: null,
        }
    },
    mounted() {
    },
    data() {
        return {
        }
    },
    methods: {
        close() {
            this.$emit('closePresentModal')
        },

    },
};
</script>

<style>
textarea {
    width: 90%; /* Ширина поля в процентах */
    height: 200px; /* Высота поля в пикселах */
    resize: none; /* Запрещаем изменять размер */
}
.file {
    display: block !important;
}
.modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, .5);
    display: table;
    transition: opacity .3s ease;
}
.modal-wrapper {
    display: table-cell;
    vertical-align: middle;
}
.modal-container {
    width: 600px;
    margin: 0px auto;
    padding: 20px 30px;
    background-color: #fff;
    border-radius: 2px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
    transition: all .3s ease;
    font-family: Helvetica, Arial, sans-serif;
}
.modal-header h3 {
    margin-top: 0;
    color: #42b983;
}
.modal-body {
    margin: 20px 0;
}
.modal-default-button {
    float: right;
}
/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */
.modal-enter {
    opacity: 0;
}
.modal-leave-active {
    opacity: 0;
}
.modal-enter .modal-container,
.modal-leave-active .modal-container {
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
}
.newMessageModal {
    position: fixed;
    bottom: 0;
    right: 0;
    z-index: 999;
    max-width: 100px !important;
}
input.apple-switch {
    position: relative;
    appearance: none;
    outline: none;
    width: 50px;
    height: 30px;
    background-color: #ffffff;
    border: 1px solid #D9DADC;
    border-radius: 50px;
    box-shadow: inset -20px 0 0 0 #ffffff;
    transition-duration: 200ms;
}
input.apple-switch:after {
    content: "";
    position: absolute;
    top: 1px;
    left: 1px;
    width: 26px;
    height: 13px;
    background-color: transparent;
    border-radius: 50%;
    box-shadow: 2px 4px 6px rgba(0, 0, 0, 0.2);
}
input.apple-switch:checked {
    border-color: #4ED164;
    box-shadow: inset 20px 0 0 0 #4ED164;
}
input.apple-switch:checked:after {
    left: 20px;
    box-shadow: -2px 4px 3px rgba(0, 0, 0, 0.05);
}
.bounce-enter-active {
    animation: bounce-in .5s;
}
.bounce-leave-active {
    animation: bounce-in .5s reverse;
}
@keyframes bounce-in {
    0% {
        transform: scale(0);
    }
    50% {
        transform: scale(1.5);
    }
    100% {
        transform: scale(1);
    }
}
.v-fade {
    transition: all 4s ease-out;
}
</style>
