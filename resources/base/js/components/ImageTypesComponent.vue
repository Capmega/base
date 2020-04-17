<template>
    <div>
        <div class="row form-group">
            <div class="col-md-4">
                <label>{{name}}</label>
                <input v-model="item_name" type="text" class="form-control">
            </div>
            <div class="form-group col-sm-12 col-md-1 mt-2">
                <button
                    @click="add()"
                    type="button"
                    class="btn btn-primary">{{add_text}}</button>
            </div>
        </div>
        <div class="row form-group" v-if="items_local.length">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{name}}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in items_local">
                            <td>{{item}}</td>
                            <td>
                                <button type="button" class="btn btn-danger" @click="remove(index)">
                                    <i class="la la-trash"></i>
                                </button>
                                <button type="button" class="btn btn-success">
                                    <i class="la la-save"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    import Swal from 'sweetalert2'

    export default {
        props: {
            items: Array,
            name: String,
            add_text: String,
            create_url: String,
            delete_url: String,
            csrf_param: String,
            csrf_token: String,
            delete_element: String,
            delete_continue: String,
            delete_deleted: String,
            delete_deleted_text: String,
            delete_cancel: String,
        },
        data: function () {
            return {
                items_local: {},
                item_name: '',
            }
        },
        methods: {
            add(index){
                this.items_local.push(this.item_name);

                var formData = new FormData();
                formData.append('name', this.item_name);

                fetch(this.create_url, {
                    method: 'POST',
                    headers:{
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': this.csrf_token,
                    },
                    body: formData,
                }).then(res => res.json())
                .catch(error => console.error('Error:', error))
                .then(response => {
                });
            },
            remove(index){
                let self = this;
                Swal.fire({
                    title: this.delete_element,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: this.delete_continue
                }).then((result) => {
                    if (result.value) {
                        var formData = new FormData();
                        formData.append('index', index);

                        this.items_local.splice( index, 1 );
                        fetch(this.delete_url, {
                            method: 'POST',
                            headers:{
                                'X-CSRF-TOKEN': this.csrf_token,
                                'Accept': 'application/json',
                            },
                            body: formData,
                        }).then(res => res.json())
                        .catch(error => console.error('Error:', error))
                        .then(response => {
                            Swal.fire(
                                self.delete_deleted,
                                self.delete_deleted_text,
                                'success'
                            )
                        });
                    }
                })
            },
        },
        mounted() {
            this.items_local = this.items;
        }
    }
</script>
