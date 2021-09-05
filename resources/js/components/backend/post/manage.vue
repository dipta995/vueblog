<template>
    <div>
        <div class="row">
            <div class="col-md-12">
            
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Post</h3>
                        <div class="card-tools">
                            <router-link to="/add-post" class="btn btn-success">Add New</router-link>
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
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Category</th>
                            <th>Content</th>
                            <th>Created By</th>
                            <th>Status</th>
                            <th>Image</th>
                            <th>Created At</th>
                            <th style="width: 130px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for='post,i in postsget'>
                        <td><input type="checkbox" :value="post.id" v-model="selected"></td>
                            <td>{{ i+1 }}</td>
                            <td>{{ post.title  }}</td>
                            <td>{{ post.slug  }}</td>
                            <td>{{ post.category.name  }}</td>
                            <td>{{ post.content| substring_custom(10) }}</td>
                            <td>{{ post.user.name  }}</td>
                            <td><span class="badge" :class="statusColor(post.status)">{{ statusName(post.status) }}</span></td>
                            <td> <img :src="imageurl(post.thumbnail)" style="height:60px;width:60px;"></td>
                            <td>{{ post.created_at | time_two }}</td>
                     
                            <td>
                                <router-link :to="`/edit-post/${post.slug}`" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></router-link>
                                <button type="button"class="btn btn-danger btn-sm" @click="remove(post.slug)"><i class="fas fa-trash-alt"></i></button>
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
                                        <button class="dropdown-item" @click="changeStatus(selected,'draft')" type="button">Draft</button>
                                        <button class="dropdown-item" @click="changeStatus(selected,'published')" type="button">Published</button>
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
        this.$store.dispatch("getPosts");
    },
    watch:{
        selected:function(selected){
           this.selectedAll=(selected.length === this.postsget.length);
            //this.selectedAll: false;
            this.isSelected=selected.length>0
        }
    },
    computed: {
        postsget(){
           return this.$store.getters.posts;
        }
    },
    methods:{
        statusName:function(status){
            let data={ draft:"Draft",published:"Published"}
                return data[status];
        },
        statusColor:function(color){
            let data={ draft:"bg-danger",published:"bg-success"}
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
     axios.post("posts/remove-items",{ids:selected})
      .then(function(response){
        // console.log(response.data.totaldel);
         
           toastr.success(response.data.totaldel +' Item Deleted successfully','Congratulation',{closeButton: true,timeOut:5000});
        
      }).catch(function(error){
          toastr.error('Post Not Deleted ','OPPS ',{closeButton: true,timeOut:5000});
      })
        this.$store.dispatch("getPosts");
   
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
     axios.post("posts/change-status",{ids:selected,val})
      .then(function(response){
         console.log(response.data);
         
           toastr.success(response.data.totaldel +' Item ' + response.data.act + ' successfully','Congratulation',{closeButton: true,timeOut:5000});
        
      }).catch(function(error){
          toastr.error('somethisng wrong ','OPPS ',{closeButton: true,timeOut:5000});
      })
        this.$store.dispatch("getPosts");
   
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

              axios.get("remove-post/" + slug)
      .then(function(response){
         
           
           toastr.success('Post Deleted successfully','Congratulation',{closeButton: true,timeOut:5000});
        
        //console.log(response.data.posts);
      }).catch(function(error){
          toastr.error('Post Not Deleted ','OPPS ',{closeButton: true,timeOut:5000});
      })
      this.$store.dispatch("getPosts");
  }
})
        },
        emptyData(){
            return this.postsget.length < 1;
        },
       
        disabled(){
            return this.postsget.length < 1;
        },
        selectAll: function(eventcheck){
            if(event.target.checked == false)
            {
                this.selected=[];
            }else{
                this.postsget.forEach((post)=>{
                this.selected.push(post.id);
                })
            }
        },
        imageurl(dir){
            return "uploads/photos/"+ dir;
        }
    }
}
</script>

<style scoped></style>