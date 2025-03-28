import { createRouter, createWebHistory } from 'vue-router';
import CarSearch from '@/views/customer/CarSearch.vue';
import CarDetails from '@/views/customer/CarDetails.vue';
import LoginPage from '@/views/LoginPage.vue';
import RegisterPage from '@/views/RegisterPage.vue';
import PaymentForm from '@/views/customer/PaymentForm.vue';
import ManageMyBooking from '@/views/customer/ManageMyBooking.vue';
import UserProfile from '@/views/customer/UserProfile.vue';
import PaymentProcess from '@/views/customer/PaymentProcess.vue';
import ContactUs from '@/views/customer/ContactUs.vue';
import AboutUs from '@/views/customer/AboutUs.vue';
import HomePage from '@/views/customer/HomePage.vue';



import DashboardManagement from '@/views/management/DashboardManagement.vue';
import AdminProfile from '@/views/management/AdminProfile.vue';
import CarsMaintenanceManagement from '@/views/management/CarsMaintenanceManagement.vue';
import CarsManagement from '@/views/management/CarsManagement.vue';
import CustomersManagement from '@/views/management/CustomersManagement.vue';
import ExpensesManagement from '@/views/management/ExpensesManagement.vue';
import PaymentsManagement from '@/views/management/PaymentsManagement.vue';
import BookingsManagement from '@/views/management/BookingsManagement.vue';
import UsersManagement from '@/views/management/UsersManagement.vue';
import CarDetailsManagement from '@/views/management/CarDetailsManagement.vue';
import EditCarManagement from '@/views/management/EditCarManagement.vue';
import AddCarManagement from '@/views/management/AddCarManagement.vue';
import ManageAvailability from '@/views/management/ManageAvailability.vue';
import CarLocationManagement from '@/views/management/CarLocationManagement.vue';
import AddExpenseManagement from '@/views/management/AddExpenseManagement.vue';
import EditExpenseManagement from '@/views/management/EditExpenseManagement.vue';
import UserDetailsManagement from '@/views/management/UserDetailsManagement.vue';

import ProgressBar from '@/components/ProgressBar.vue';



const routes = [



  {
    path: '/test',
    name: 'ProgressBar',
    component: ProgressBar,
  },




  {
    path: '/',
    name: 'HomePage',
    component: HomePage,
  },



  {
    path: '/cars',
    name: 'cars',
    component: CarSearch,
  },


  
  {
    path: '/car/:id',
    name: 'CarDetails',
    component: CarDetails,
    props: true, // Pass the `id` as a prop to the component
  },



  {
    path: '/login',
    name: 'LoginPage',
    component: LoginPage,
  },



  {
    path: '/register',
    name: 'RegisterPage',
    component: RegisterPage,
  },


  {
    path: '/checkout',
    name: 'PaymentForm',
    component: PaymentForm,
  },


  {
    path: '/managemybooking',
    name: 'ManageMyBooking',
    component: ManageMyBooking,
  },


  {
    path: '/profile',
    name: 'UserProfile',
    component: UserProfile,
    meta: { requiresAuth: true }
  },


  {
    path: '/paymentprocess',
    name: 'PaymentProcess',
    component: PaymentProcess,
  },


  
  {
    path: '/contactus',
    name: 'ContactUs',
    component: ContactUs,
  },


  {
    path: '/aboutus',
    name: 'AboutUs',
    component: AboutUs,
  },

  

  {
    path: '/management/dashboard',
    name: 'DashboardManagement',
    component: DashboardManagement,
    meta: { requiresAuth: true, requiresAdmin: true }
  },

  {
    path: '/management/profile',
    name: 'AdminProfile',
    component: AdminProfile,
    meta: { requiresAuth: true, requiresAdmin: true }
  },



  {
    path: '/management/carsmaintenance',
    name: 'CarsMaintenanceManagement',
    component: CarsMaintenanceManagement,
    meta: { requiresAuth: true, requiresAdmin: true }
  },




  {
    path: '/management/cars',
    name: 'CarsManagement',
    component: CarsManagement,
    meta: { requiresAuth: true, requiresAdmin: true }
  },


  {
    path: '/management/customers',
    name: 'CustomersManagement',
    component: CustomersManagement,
    meta: { requiresAuth: true, requiresAdmin: true }
  },


  {
    path: '/management/expenses',
    name: 'ExpensesManagement',
    component: ExpensesManagement,
    meta: { requiresAuth: true, requiresAdmin: true }
  },



  {
    path: '/management/payments',
    name: 'PaymentsManagement',
    component: PaymentsManagement,
    meta: { requiresAuth: true, requiresAdmin: true }
  },




  {
    path: '/management/bookings',
    name: 'BookingsManagement',
    component: BookingsManagement,
    meta: { requiresAuth: true, requiresAdmin: true }
  },




  {
    path: '/management/users',
    name: 'UsersManagement',
    component: UsersManagement,
    meta: { requiresAuth: true, requiresAdmin: true }
  },



  {
    path: '/management/cardetails/:id',
    name: 'CarDetailsManagement',
    component: CarDetailsManagement,
    meta: { requiresAuth: true, requiresAdmin: true }
  },



  {
    path: '/management/editcar/:id',
    name: 'EditCarManagement',
    component: EditCarManagement,
    meta: { requiresAuth: true, requiresAdmin: true }
  },

  {
    path: '/management/addcar',
    name: 'AddCarManagement',
    component: AddCarManagement,
    meta: { requiresAuth: true, requiresAdmin: true }
  },


  {
    path: '/management/car/:id/availability',
    name: 'ManageAvailability',
    component: ManageAvailability,
    meta: { requiresAuth: true, requiresAdmin: true }
  },


  {
    path: '/management/car/:id/locations',
    name: 'CarLocationManagement',
    component: CarLocationManagement,
    meta: { requiresAuth: true, requiresAdmin: true }
  },



  
  {
    path: '/management/addexpense',
    name: 'AddExpenseManagement',
    component: AddExpenseManagement,
    meta: { requiresAuth: true, requiresAdmin: true }
  },


  {
    path: '/management/expense/:id',
    name: 'EditExpenseManagement',
    component: EditExpenseManagement,
    meta: { requiresAuth: true, requiresAdmin: true }
  },

  

  {
    path: '/management/users/:id',
    name: 'UserDetailsManagement',
    component: UserDetailsManagement,
    meta: { requiresAuth: true, requiresAdmin: true }
  },


];

const router = createRouter({
  history: createWebHistory(), // Uses HTML5 history mode
  routes,
});



router.beforeEach((to, from, next) => {
  const isAuthenticated = localStorage.getItem("token"); // Check if the user is authenticated
  const isAdmin = localStorage.getItem("IsAdmin") === "true"; // Check if the user is an admin

  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!isAuthenticated) {
      // If not authenticated, redirect to login using router.push()
      router.push('/login');
    } else if (to.matched.some(record => record.meta.requiresAdmin) && !isAdmin) {
      // If the route requires admin privileges and the user is not an admin
      router.push('/'); // Redirect to the home page or a regular user route
    } else {
      // If authenticated and (admin check passes or not required), proceed
      next();
    }
  } else {
    next(); // Allow access to routes without authentication check
  }
});






export default router;
