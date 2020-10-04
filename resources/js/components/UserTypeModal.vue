<template>
    <transition name="model">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            Confirmation
                            <button
                                type="button"
                                class="close btn-close-modal"
                                @click="setModalClose"
                            >
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <label for="select-user-type">Choose User Type</label>
                                </div>
                                <select v-model="userTypeId"
                                        class="custom-select"
                                        id="select-user-type"
                                >
                                    <option
                                        v-for="type in userTypeList"
                                        :key="type.id"
                                        :value="type.id"
                                    >
                                        {{type.type_name}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div style="float:right;">
                                <button
                                    type="button"
                                    class="btn btn-primary"
                                    @click="submitData"
                                >
                                    Confirm
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        name: "UserTypeModal",

        props: ['currentUserTypeId', 'currentUserId'],

        data(){
            return{
                userTypeId: this.currentUserTypeId,
                userId: this.currentUserId,
                userTypeList: []
            }
        },

        methods: {
            //get all user type
            getAllUserType() {
                axios.get('/api/userType')
                .then((res) => {
                    this.userTypeList = res.data
                })
            },
            //update new user_type and refetch font page
            submitData(){
                axios.post(`/api/userType/update/${this.userTypeId}/${this.userId}`)
                .then((res) => {
                    this.$emit('refetchUser');
                    this.$emit('onClose');
                })
                .catch((err) => {
                    console.log(err);
                })
            },

            //close modal
            setModalClose(){
                this.$emit('onClose', false)
            }
        },

        mounted() {
            this.getAllUserType()
        }
    }
</script>

<style scoped>
    .modal-mask{
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,.5);
        display: table;
        transition: opacity .3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

    .modal-content {
        width: 800px;
        margin: auto;
    }

    .modal-dialog {
        margin-left: 350px;
    }

    .btn-close-modal {
        float: right;
    }
</style>
