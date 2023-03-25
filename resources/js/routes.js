let login = require('./components/auth/login.vue').default;
let register = require('./components/auth/register.vue').default;
let forget = require('./components/auth/forget.vue').default;
let logout = require('./components/auth/logout.vue').default;

let home = require('./components/Home.vue').default;



//-------Tax Route--------
let tax = require('./components/tax/index.vue').default;
let editTax = require('./components/tax/edit.vue').default;
//-------Tax Route--------


//------Employee Route-----
let employee = require('./components/employee/index.vue').default;
let editEmployee = require('./components/employee/edit.vue').default;
//------Employee Route-----


//------Supplier Route-----
let supplier = require('./components/supplier/index.vue').default;
let editSupplier = require('./components/supplier/edit.vue').default;
//------Supplier Route-----

//------Unit Route-----
let unit = require('./components/unit/index.vue').default;
let editUnit = require('./components/unit/edit.vue').default;
//------Unit Route-----

//------Brand Route-----
let brand = require('./components/brand/index.vue').default;
let editBrand = require('./components/brand/edit.vue').default;
//------Brand Route-----

//------Category Route-----
let category = require('./components/category/index.vue').default;
let editCategory = require('./components/category/edit.vue').default;
//------Category Route-----

//------------Product Route-------------------------------
let addProduct = require('./components/product/create.vue').default;
let product = require('./components/product/index.vue').default;
let editProduct = require('./components/product/edit.vue').default;
let stock = require('./components/product/stock.vue').default;
//------------Product Route-------------------------------


//------Expense Route-----
let expense = require('./components/expense/index.vue').default;
let editExpense = require('./components/expense/edit.vue').default;
//------Expense Route-----


//------------Employee Salary Route------------------------------
let all = require('./components/salary/AllEmployee.vue').default;
let paySalary = require('./components/salary/PaySalary.vue').default;
let salary = require('./components/salary/Salary.vue').default;
let viewSalary = require('./components/salary/View.vue').default;
let editSalary = require('./components/salary/Edit.vue').default;
//------------Employee Salary Route------------------------------


//------Customer Route-----
let customer = require('./components/customer/index.vue').default;
let editCustomer = require('./components/customer/edit.vue').default;
//------Customer Route-----


//-------POS Route-----------
let pos = require('./components/pos/pointOfSale.vue').default;
//-------POS Route-----------


//------Order Route----------
let order = require('./components/order/order.vue').default;
let viewOrder = require('./components/order/vieworder.vue').default;
let search = require('./components/order/search.vue').default;
//------Order Route----------


//--------Report Route---------
let lossProfit = require('./components/report/lossProfit.vue').default;
//--------Report Route---------


//------Brand Route-----
let user = require('./components/user/index.vue').default;
let editUser = require('./components/user/edit.vue').default;
//------Brand Route-----


export const routes = [
    { path: '/', component: login, name: '/' },
    { path: '/register', component: register, name: 'register' },
    { path: '/forget', component: forget, name: 'forget' },
    { path: '/logout', component: logout, name: 'logout' },
    { path: '/home', component: home, name: 'home' },

    //tax
    { path: '/tax', component: tax, name: 'tax' },
    { path: '/edit-tax/:id', component: editTax, name: 'editTax' },

    //Employee
    { path: '/user', component: user, name: 'user' },
    { path: '/edit-user/:id', component: editUser, name: 'editUser' },

    //Employee
    { path: '/employee', component: employee, name: 'employee' },
    { path: '/edit-employee/:id', component: editEmployee, name: 'editEmployee' },

    //Supplier
    { path: '/supplier', component: supplier, name: 'supplier' },
    { path: '/edit-supplier/:id', component: editSupplier, name: 'editSupplier' },

    //Unit
    { path: '/unit', component: unit, name: 'unit' },
    { path: '/edit-unit/:id', component: editUnit, name: 'editUnit' },

    //Brand
    { path: '/brand', component: brand, name: 'brand' },
    { path: '/edit-brand/:id', component: editBrand, name: 'editBrand' },

    { path: '/category', component: category, name: 'category' },
    { path: '/edit-category/:id', component: editCategory, name: 'editCategory' },

    { path: '/add-product', component: addProduct, name: 'addProduct' },
    { path: '/product', component: product, name: 'product' },
    { path: '/edit-product/:id', component: editProduct, name: 'editProduct' },
    { path: '/stock', component: stock, name: 'stock' },

    { path: '/expense', component: expense, name: 'expense' },
    { path: '/edit-expense/:id', component: editExpense, name: 'editExpense' },

    { path: '/given-salary', component: all, name: 'givenSalary' },
    { path: '/pay-salary/:id', component: paySalary, name: 'paySalary' },

    { path: '/salary', component: salary, name: 'salary' },
    { path: '/view-salary/:id', component: viewSalary, name: 'viewSalary' },
    { path: '/edit-salary/:id', component: editSalary, name: 'editSalary' },

    { path: '/customer', component: customer, name: 'customer' },
    { path: '/edit-customer/:id', component: editCustomer, name: 'editCustomer' },

    { path: '/pos', component: pos, name: 'pos' },

    //Order componet link
    { path: '/order', component: order, name: 'order' },
    { path: '/view-order/:id', component: viewOrder, name: 'view-order' },
    { path: '/search', component: search, name: 'search' },

    //Report Component Here
    { path: '/profit-loss', component: lossProfit, name: 'lossProfit' },


]