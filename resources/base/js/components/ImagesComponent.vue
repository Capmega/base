<template>
    <div class="">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{image}}</th>
                    <th>{{type}}</th>
                    <th>{{alt}}</th>
                    <th>{{menu}}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(image, index) in items_local">
                    <td>{{(index+1)}}</td>
                    <td>
                        <img :src="link_url + image[key_image] + '/' + image.id + '-thumbnail.jpg'" alt="">
                    </td>
                    <td>
                        <select v-model="items_local[index].type" class="form-control" name="">
                            <option value=""></option>
                            <option v-for="image in images_types">{{image}}</option>
                        </select>
                    </td>
                    <td>
                        <textarea v-model="items_local[index].alt" class="form-control" rows="3" cols="50"></textarea>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger" @click="remove(index, image.id)">
                            <i class="la la-trash"></i>
                        </button>
                        <button type="button" class="btn btn-primary" @click="update(index, image.id)">
                            <i class="la la-file-image-o"></i>
                        </button>
                        <button type="button" class="btn btn-success" @click="save(index)">
                            <i class="la la-save"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="modal fade" id="custom-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">{{sizes}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <div class="row form-group">
                      <div class="col-md-4">
                          <label>{{name}}</label>
                          <input v-model="size_name" v-mask="'AAAAAAAA'" type="text" class="form-control">
                      </div>
                      <div class="col-md-2">
                          <label>{{width}}</label>
                          <input v-model="size_width" v-mask="'####'" type="text" class="form-control">
                      </div>
                      <div class="col-md-2">
                          <label>{{height}}</label>
                          <input v-model="size_height" v-mask="'####'" type="text" class="form-control">
                      </div>
                      <div class="col-md-2">
                          <label>{{quality}}</label>
                          <input v-model="size_quality" v-mask="'##'" type="text" class="form-control">
                      </div>
                      <div class="form-group col-sm-12 col-md-1 mt-2">
                          <button
                              @click="addSize()"
                              type="button"
                              class="btn btn-primary">{{add_text}}</button>
                      </div>
                  </div>
                  <table class="table table-bordered">
                      <thead>
                          <tr>
                              <th>{{name}}</th>
                              <th>{{width}}</th>
                              <th>{{height}}</th>
                              <th>{{quality}}</th>
                              <th></th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr v-for="(size, index) in sizes_local">
                              <td>{{size.name}}</td>
                              <td>{{size.width}} px</td>
                              <td>{{size.height}} px</td>
                              <td>{{size.quality}}%</td>
                              <td>
                                  <button type="button" class="btn btn-danger" @click="removeSize(index)">
                                      <i class="la la-trash"></i>
                                  </button>
                              </td>
                          </tr>
                      </tbody>
                  </table>
                  <div class="col-sm-12">
                      <fieldset class="radio">
                          <label>
                              <input type="radio" v-model="save_type" value="only_this" checked="">
                              {{only_this}}
                          </label>
                      </fieldset>
                      <fieldset class="radio">
                          <label>
                              <input type="radio" v-model="save_type" value="only_category" >
                              {{only_category}}
                          </label>
                      </fieldset>
                      <fieldset class="radio">
                          <label>
                              <input type="radio" v-model="save_type" value="only_blog">
                              {{only_blog}}
                          </label>
                      </fieldset>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{cancel}}</button>
                <button type="button" class="btn btn-primary" @click="saveSizes">{{save_text}}</button>
              </div>
            </div>
          </div>
        </div>

    </div>
</template>

<script>
    import Swal from 'sweetalert2'

    export default {
        props: {
            items: Array,
            type: String,
            image: String,
            alt: String,
            menu: String,
            save_url: String,
            delete_url: String,
            csrf_param: String,
            csrf_token: String,
            delete_element: String,
            delete_continue: String,
            delete_deleted: String,
            delete_deleted_text: String,
            save_saved: String,
            save_saved_text: String,
            images_types: Array,
            sizes: String,
            name: String,
            height: String,
            width: String,
            quality: String,
            save_text: String,
            cancel: String,
            add_text: String,
            save_sizes_url: String,
            only_this: String,
            only_category: String,
            only_blog: String,
            sure_continue: String,
            link_url: String,
            key_image: String,
        },
        data: function () {
            return {
                items_local: {},
                sizes_local: {},
                size_name: '',
                size_height: '',
                size_width: '',
                size_quality: '',
                save_type: 'only_this',
                current_image_id: '',
            }
        },
        methods: {
            update(index, id){
                this.sizes_local = this.items_local[index].sizes;
                this.current_image_id = this.items_local[index].id;
                $('#custom-modal').modal('show')
            },
            save(index){
                let self = this;
                var formData = new FormData();
                formData.append('id_image', this.items_local[index].id);
                formData.append('type', this.items_local[index].type);
                formData.append('alt', this.items_local[index].alt);

                fetch(this.save_url, {
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
                        self.save_saved,
                        self.save_saved_text,
                        'success'
                    )
                });
            },
            remove(index, id){
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
                        formData.append('id_image', id);
                        formData.append(this.csrf_param, this.csrf_token);
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
            addSize(index){
                this.sizes_local.push({
                    name: this.size_name,
                    height: this.size_height,
                    width: this.size_width,
                    quality: this.size_quality,
                });
            },
            removeSize(index){
                this.sizes_local.splice( index, 1 );
            },
            saveSizes(){
                let self = this;
                Swal.fire({
                    title: this.sure_continue,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: this.delete_continue
                }).then((result) => {
                    if (result.value) {
                        var formData = new FormData();
                        formData.append('sizes', JSON.stringify(self.sizes_local));
                        formData.append('save_type', self.save_type);
                        formData.append('id', self.current_image_id);

                        fetch(this.save_sizes_url, {
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
                                self.save_saved,
                                self.save_saved_text,
                                'success'
                            );
                            $('#custom-modal').modal('hide');
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
