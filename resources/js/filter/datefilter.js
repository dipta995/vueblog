import moment from "moment";
import Vue from "vue";

Vue.filter('time_one',function(gettime){
  return moment(gettime).format('MMMM Do YYYY, h:mm:ss a');
});
Vue.filter('time_two',function(gettimes){
    // moment(gettime).format('MMMM Do YYYY, h:mm:ss a')
    return moment(gettimes).format("MMM Do YY"); 
  });
  Vue.filter('substring_custom',function(content,length){
    return content.substring(0,length);
  });