import home from '../components/backend/home';
//Categories
import cat from '../components/backend/category/manage';
import addcategory from '../components/backend/category/create';
import editcategory from '../components/backend/category/edit';

//Posts
import post from '../components/backend/post/manage';
import addpost from '../components/backend/post/create';
import editpost from '../components/backend/post/edit';
 


export const routes =[
    { path: '/home',component : home },
    { path: '/cats',component : cat },
    { path: '/add-category',component : addcategory },
    { path: '/edit-category/:slug',component : editcategory },
    { path: '/posts',component : post },
    { path: '/add-post',component : addpost },
    { path: '/edit-post/:slug',component : editpost },
];
