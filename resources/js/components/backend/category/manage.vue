<template>
    <div>
        <div class="row">
            <div class="col-md-10">
            
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Category</h3>
                        <div class="card-tools">
                            <router-link to="/add-category" class="btn btn-success">Add New</router-link>
                        </div>
                    </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table table-xl">
                        <thead>
                            <tr>
                            <th><input :disabled="emptyData()" type="checkbox" @click="selectAll"  v-model="selectedAll"></th>
                            <th style="width: 10px">#</th>
                            <th>Name</th>
                            <th>slug</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th style="width: 100px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for='category,i in categoriesget'>
                        <td><input type="checkbox" :value="category.id"  v-model="selected"></td>
                            <td>{{ i+1 }}</td>
                            <td>{{ category.name | substring_custom(3) }}</td>
                            <td>{{ category.slug }}</td>
                            <td><span class="badge" :class="statusColor(category.status)">{{ statusName(category.status) }}</span></td>
                            <td>{{ category.created_at | time_two }}</td>
                     
                            <td>
                                <router-link :to="`/edit-category/${category.slug}`" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></router-link>
                                <button type="button"class="btn btn-danger btn-sm" @click="remove(category.slug)"><i class="fas fa-trash-alt"></i></button>
                            </td>
                            </tr>
                            <tr v-if="!emptyData()">
                                <td  colspan="6">
                                   <div class="dropdown">
  <button :disabled="!isSelected" class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <button @click="removeItems(selected)" class="dropdown-item" type="button">Remove</button>
    <button class="dropdown-item" @click="changeStatus(selected,1)" type="button">Active</button>
    <button class="dropdown-item"  @click="changeStatus(selected,0)" type="button">Inactive</button>
  </div>
</div>
                                </td>
                            </tr>
                            <tr v-if="emptyData()">
                                <td  colspan="6">
                                    </h5 class"text-center text-danger">Data Not found</h5>
                                </td>
                            </tr>
                            
                             
                        </tbody>
                        </table>
                       
                    </div>
                    <!-- /.card-body -->
                    
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "manage",
    data: function(){
        return {
        selected: [],
        isSelected: false,
        selectedAll: false,
        val:false
        }
    },
        
    
    mounted(){
        this.$store.dispatch("getCategories");
    },
     watch:{
        selected:function(selected){
           this.selectedAll=(selected.length === this.categoriesget.length);
            //this.selectedAll: false;
            this.isSelected=selected.length>0
        }
    },
    computed: {
        categoriesget(){
           return this.$store.getters.categories;
        }
    },
    methods:{
        statusName:function(status){
            let data={ 0:"Inactive",1:"Active"}
                return data[status];
        },
        statusColor:function(color){
            let data={ 0:"bg-danger",1:"bg-success"}
                return data[color];
        },
         removeItems:function(selected){  Swal.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.isConfirmed) {
     axios.post("cats/remove-items",{ids:selected})
      .then(function(response){
        // console.log(response.data.totaldel);
         
           toastr.success(response.data.totaldel +' Item Deleted successfully','Congratulation',{closeButton: true,timeOut:5000});
        
      }).catch(function(error){
          toastr.error('Categories Not Deleted ','OPPS ',{closeButton: true,timeOut:5000});
      })
        this.$store.dispatch("getCategories");
   
  }
})
 },
changeStatus:function(selected,val){  Swal.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.isConfirmed) {
     axios.post("cats/change-status",{ids:selected,val})
      .then(function(response){
         console.log(response.data);
         
           toastr.success(response.data.totaldel +' Item ' + response.data.act + ' successfully','Congratulation',{closeButton: true,timeOut:5000});
        
      }).catch(function(error){
          toastr.error('Categories Not Deleted ','OPPS ',{closeButton: true,timeOut:5000});
      })
        this.$store.dispatch("getCategories");
   
  }
})
 },

        remove:function(slug){
    
    Swal.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.isConfirmed) {
    // Swal.fire(
    //   'Deleted!',
    //   'Your file has been deleted.',
    //   'success'
    // )

              axios.get("remove-category/" + slug)
      .then(function(response){
         
           
           toastr.success('Category Deleted successfully','Congratulation',{closeButton: true,timeOut:5000});
        
        //console.log(response.data.categories);
      }).catch(function(error){
          toastr.error('Category Not Deleted ','OPPS ',{closeButton: true,timeOut:5000});
      })
      this.$store.dispatch("getCategories");
  }
})
        },
        emptyData(){
            return this.categoriesget.length < 1;
        },disabled(){
            return this.categoriesget.length < 1;
        },
         selectAll: function(eventcheck){
            if(event.target.checked == false)
            {
                this.selected=[];
            }else{
                this.categoriesget.forEach((Category)=>{
                this.selected.push(Category.id);
                })
            }
        }
    }
}
</script>

<style scoped></style>