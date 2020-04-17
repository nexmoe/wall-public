import Vue from "vue";
import Router from "vue-router";
import Home from "@/components/Home";
import Category from "@/components/Category";
import Message from "@/components/Message";
import Edit from "@/components/Edit";
import Login from "@/components/Login";
import Notice from "@/components/Notice";
import Setting from "@/components/Setting";
import SettingHome from "@/components/Setting/Home";
import SettingAbout from "@/components/Setting/About";

Vue.use(Router);

export default new Router({
  mode: "history",
  routes: [
    {
      path: "/",
      component: Home,
      meta: {
        keepAlive: true,
        title: "墙"
      }
    },
    {
      path: "/category/:id",
      component: Category,
      meta: {
        keepAlive: false,
        title: "墙"
      }
    },
    {
      path: "/edit",
      component: Edit,
      meta: {
        keepAlive: false,
        title: "墙"
      }
    },
    {
      path: "/edit/:id",
      component: Edit,
      meta: {
        keepAlive: false,
        title: "墙"
      }
    },
    {
      path: "/message/:id",
      component: Message,
      meta: {
        keepAlive: false,
        title: "墙"
      }
    },
    {
      path: "/login",
      component: Login,
      meta: {
        keepAlive: false,
        title: "登录"
      }
    },
    {
      path: "/notice",
      component: Notice,
      meta: {
        keepAlive: false,
        title: "通知"
      }
    },
    {
      path: "/setting",
      component: Setting,
      meta: {
        keepAlive: true,
        title: "墙"
      },
      children: [
        {
          path: "home",
          component: SettingHome
        },
        {
          path: "about",
          component: SettingAbout
        }
      ]
    }
  ]
});
