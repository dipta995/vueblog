<template>
 <div>
 <div class="card">
 <div class="card-header">
                        <h3 class="card-title">Category</h3>
                        <div class="card-tools">
                            <router-link to="/cats" class="btn btn-success"> Category</router-link>
                        </div>
                    </div>
 </div>

<form @submit.prevent="addCategory" @keydown="form.onKeydown($event)">
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
      name: null,
      status: 1
    })
  }),

  methods: {
    async addCategory () {
        let reset = this;
      const response = await this.form.post('/add-category')
      .then(function(result){
        // Toast.fire({
        // icon: 'success',
        // title: 'Category Created successfully'
        // })

    toastr.success('Category Created successfully','Congratulation',{closeButton: true,timeOut:5000});
        reset.form.name='';
        reset.form.status=1;
      })
      
    }
    // addCategory: function()
    // { 
    //     console.log('test');
    // }
//for reset

    
  }
}
</script>
