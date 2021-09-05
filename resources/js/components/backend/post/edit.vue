<template>
 <div>
 <div class="card">
 <div class="card-header">
                        <h3 class="card-title">Update Post</h3>

                        <div class="card-tools">
                            <router-link to="/posts" class="btn btn-success"> Posts</router-link>
                        </div>
                    </div>
 </div>

<form @submit.prevent="updatePost" @keydown="form.onKeydown($event)">
  <AlertError :form="form" />
  <!-- <AlertErrors :form="form" /> -->
 

  <div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input id="name" v-model="form.name" type="text"  class="form-control">
    <HasError :form="form" field="name" />
  </div>
  <div class="mb-3">
    <label for="name" class="form-label">Status</label> <br>
   <label class="radio-inline">
      <input type="radio" id="active" value="1" checked v-model="form.status">Active
    </label>
    <label class="radio-inline">
      <input type="radio" id="inactive" value="0" v-model="form.status">In active
    </label>
    <HasError :form="form" field="status" />
  </div>
 


  <Button type="submit" :form="form" class="btn btn-primary">
    Update
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
      name: null,
      id: null,
      status: null
    })
  }),
  mounted() {
    this.getPost();
  },

  methods: {
    async updatePost () {
        let this_ = this;
       this.form.post('/update-post')
      .then(function(response){
 
    toastr.success('Post updated successfully','Congratulation',{closeButton: true,timeOut:5000});

        this_.$router.push("/posts/");
      }).catch(function(error){
           toastr.error('Something wrong try again','OPPS !',{closeButton: true,timeOut:5000});
      })
      
    },
    getPost: function (){
      const this_ = this;
      axios.get("/show-post/" + this.$route.params.slug).then(function(response){
         this_.form.fill(response.data.post);
      }).catch(function(error){
           
      })
    }
    
  }
}
</script>
