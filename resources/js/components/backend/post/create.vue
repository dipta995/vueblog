<template>
 <div>
 <div class="card">
 <div class="card-header">
                        <h3 class="card-title">Post</h3>
                        <div class="card-tools">
                            <router-link to="/posts" class="btn btn-success"> Post</router-link>
                        </div>
                    </div>
 </div>

<form @submit.prevent="addPost" @keydown="form.onKeydown($event)" enctype="multipart/form-data">
  <AlertError :form="form" />
  <!-- <AlertErrors :form="form" /> -->
 

  <div class="mb-3">
    <label for="category_id" class="form-label">Category</label>
 
    <select id="category_id" v-model="form.category_id" class="form-control">
      <option value="">--Choose--</option>
      
       <option  v-for="cat in categoriesget" :value="cat.id">{{cat.name}} </option>
    </select>
    <HasError :form="form" field="name" />
  </div>

   <div class="mb-3">
    <label for="title" class="form-label">Post Title</label>
    <input id="title" v-model="form.title" type="text"  class="form-control">
    <HasError :form="form" field="title" />
  </div>
  <div class="mb-3">
    <label for="content" class="form-label">Post Title</label>
    <textarea id="content" v-model="form.content"  class="form-control"></textarea>
    <HasError :form="form" field="content" />
  </div>
    <div class="mb-3">
    <label for="thumbnail" class="form-label">Thumbnail</label>
    <input id="thumbnail" name="thumbnail" type="file"  class="form-control" @change="loadThumbnail($event)">
    <HasError :form="form" field="name"  />
   

  <img :src="form.thumbnail" alt="">
  </div> 
  
  <div class="mb-3">
    <label for="status" class="form-label">Status</label> <br>
   <label class="radio-inline">
      <input type="radio" id="active" value="1" checked v-model="form.status">Published
    </label>
    <label class="radio-inline">
      <input type="radio" id="inactive" value="0" v-model="form.status">Draft
    </label>
    <HasError :form="form" field="status" />
  </div>
 


  <Button type="submit" :form="form" class="btn btn-primary">
    create
  </Button>
</form>
</div>
</template>

<script>
import Form from 'vform'
import { Button, HasError, AlertError } from 'vform/src/components/bootstrap5'

export default {
  components: {
    Button, HasError, AlertError
  },

  data: () => ({
    form: new Form({
      category_id:'',
      title:'',
      thumbnail:'',
      content:'',
      status:'0'
    })
  }),
mounted(){
         
        this.$store.dispatch("getActiveCategories");
    },
    computed: {
        categoriesget(){
           return this.$store.getters.categories;
        }
    },
  methods: {
    async addPost () {
        let reset = this;
      const response = await this.form.post('/add-post')
      .then(function(result){
        
    toastr.success('Post Created successfully','Congratulation',{closeButton: true,timeOut:5000});
        reset.form.category_id='';
        reset.form.title='';
        reset.form.thumbnail='';
        reset.form.content='';
        reset.form.status='0';

      })
    },
    loadThumbnail: function(e){
      let file =e.target.files[0];
      let reader = new FileReader();
      reader.onload = e=>{
        this.form.thumbnail = e.target.result;  
      }
      reader.readAsDataURL(file);
    }
//for reset

    
  }
}
</script>
