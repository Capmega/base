<template>
    <div>
        <div class="row form-group">
            <div class="col-md-2">
                <label>{{name}}</label>
                <input v-model="size_name" v-mask="'AAAAAAAA'" type="text" class="form-control">
            </div>
            <div class="col-md-1">
                <label>{{width}}</label>
                <input v-model="size_width" v-mask="'####'" type="text" class="form-control">
            </div>
            <div class="col-md-1">
                <label>{{height}}</label>
                <input v-model="size_height" v-mask="'####'" type="text" class="form-control">
            </div>
            <div class="col-md-1">
                <label>{{quality}}</label>
                <input v-model="size_quality" v-mask="'##'" type="text" class="form-control">
            </div>
            <div class="col-md-2">
                <label>{{transparency}}</label>
                <input v-model="size_transparency" v-mask="'##'" type="text" class="form-control">
            </div>
            <div class="col-md-2">
                <label>{{resizing}}</label>
                <input v-model="size_resizing" v-mask="'##'" type="text" class="form-control">
            </div>
            <div class="form-group col-sm-12 col-md-1 mt-2">
                <button
                    @click="add()"
                    type="button"
                    class="btn btn-primary">{{add_text}}</button>
            </div>
        </div>
        <div class="row form-group" v-if="sizes_local.length">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{name}}</th>
                            <th>{{width}}</th>
                            <th>{{height}}</th>
                            <th>{{quality}}</th>
                            <th>{{transparency}}</th>
                            <th>{{resizing}}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(size, index) in sizes_local">
                            <td>{{size.name}}</td>
                            <td>{{size.width}} px</td>
                            <td>{{size.height}} px</td>
                            <td>{{size.quality}}%</td>
                            <td>{{size.transparency}}</td>
                            <td>{{size.resizing}}</td>
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
            height: String,
            width: String,
            quality: String,
            transparency: String,
            resizing: String,
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
                sizes_local: {},
                size_name: '',
                size_height: '',
                size_width: '',
                size_quality: '',
                size_transparency: '',
                size_resizing: '',
            }
        },
        methods: {
            add(index){
                this.sizes_local.push({
                    name: this.size_name,
                    height: this.size_height,
                    width: this.size_width,
                    quality: this.size_quality,
                    transparency: this.size_transparency,
                    resizing: this.size_resizing,
                });

                var formData = new FormData();
                formData.append('name', this.size_name);
                formData.append('height', this.size_height);
                formData.append('width', this.size_width);
                formData.append('quality', this.size_quality);
                formData.append('transparency', this.size_transparency);
                formData.append('resizing', this.size_resizing);

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

                        this.sizes_local.splice( index, 1 );
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
            this.sizes_local = this.items;
        }
    }
</script>
