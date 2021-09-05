

export default{
     state: {
      categoriedata:[],
      postdata:[]
  },
  getters: {
    categories(state){
      return state.categoriedata;
    },
    posts(state){
      return state.postdata;
    }
  },
  actions:{
    getCategories(datas){
      axios.get("get-category")
      .then(function(response){
        datas.commit("getcategories",response.data.categories)
        //console.log(response.data.categories);
      }).catch(function(error){
        console.log(error);
      })
    },
    getActiveCategories(datas){
      axios.get("get-active-category")
      .then(function(response){
        datas.commit("getcategories",response.data.categories)
        //console.log(response.data.categories);
      }).catch(function(error){
        console.log(error);
      })
    },

    getPosts(datas){
      axios.get("get-post")
      .then(function(response){
        datas.commit("getposts",response.data.posts)
        
      }).catch(function(error){
        console.log(error);
      })
    }
  },
  mutations: {
    getcategories(state,dataget){
      return state.categoriedata = dataget;
    },

    getposts(state,dataget){
      return state.postdata = dataget;
    }
  }
}
