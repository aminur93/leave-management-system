<script>
export default {
  name: "LeaveLayout",
  data(){
    return{
      drawer: null ,
      selectedItem: 0,

      items: [
        { title: 'Profile', icon: 'mdi mdi-account-tie', route: '/dashboard/profile'},
        { title: 'Settings', icon: 'mdi-cog', route: '/dashboard/change-password' },
      ],

      dropDownItems: [
        {
          action: 'mdi-account-circle',
          items: [
            { title: 'User', icon: 'mdi mdi-plus', route: '/dashboard/user'},
            { title: 'Roles', icon: 'mdi mdi-plus', route: '/dashboard/role'},
            { title: 'Permission', icon: 'mdi mdi-plus', route: '/dashboard/permission'}
          ],
          title: 'User Management'
        },
      ],

      open: ['Users'],
      cruds: [
        ['Create', 'mdi-plus-outline'],
        ['Read', 'mdi-file-outline'],
        ['Update', 'mdi-update'],
        ['Delete', 'mdi-delete'],
      ],

    }
  },

  computed: {},

  mounted(){
  },

  methods: {
    logout(){
      this.$store.dispatch('logout').then(() => {
        this.$router.push('/');
      })
    }
  }
}
</script>

<template>
    <v-navigation-drawer
        app
        v-model="drawer"
        id="default-sidebar"
        :permanent="$vuetify.display.mdAndUp"
        temporary
    >
      <v-list-item
          prepend-avatar="https://randomuser.me/api/portraits/men/85.jpg"
          title="John Leider"
          nav
          style="margin-top: 10px"
      >
      </v-list-item>

      <v-divider class="custom_divider"></v-divider>

      <v-list density="compact" nav>
        <v-list-item class="new_theme" router to="/dashboard" prepend-icon="mdi-view-dashboard" title="Dashboard" value="Dashboard"></v-list-item>
        <v-list-item class="new_theme" router to="/dashboard/leave-category" prepend-icon="mdi mdi-clipboard-list" title="Leave Category" value="Leave Category"></v-list-item>
        <v-list-item class="new_theme" router to="/dashboard/leave" prepend-icon="mdi mdi-bed" title="Leave" value="Leave"></v-list-item>
        <v-list-item class="new_theme" router to="/dashboard/leave-comment" prepend-icon="mdi mdi-comment" title="Leave Comment" value="Leave Comment"></v-list-item>

        <v-list-group
            v-for="item in dropDownItems"
            :key="item.title"
            :value="item.title"
            :items="item.items"
            no-action
        >
          <template v-slot:activator="{ props }">
            <v-list-item v-bind="props" :prepend-icon="item.action" :title="item.title" class="new_theme"></v-list-item>
          </template>

          <v-list-item
              v-for="child in item.items"
              :key="child.title"
              :prepend-icon="child.icon"
              :title="child.title"
              :value="child.title"
              router :to="child.route"
              exact
              class="sub_new_theme_text"
          >
          </v-list-item>
        </v-list-group>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar :elevation="2">
        <template v-slot:prepend>
          <v-app-bar-nav-icon  @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
        </template>

        <v-app-bar-title :class="['text-subtitle-1', 'text-grey']">Leave Management</v-app-bar-title>

        <template v-slot:append>
          <v-btn icon="mdi-heart"></v-btn>

          <v-btn icon="mdi-magnify"></v-btn>

          <v-menu transition="scale-transition">
            <template v-slot:activator="{ props }">
              <v-btn
                  color="primary"
                  v-bind="props"
                  icon="mdi-dots-vertical"
              >
              </v-btn>
            </template>

            <v-list style="margin-top: 5px">
              <v-list-item
                  v-for="(item, i) in items"
                  :key="i"
                  router :to="item.route"
                  exact
              >
                <v-list-item-title style="cursor: pointer">
                  <v-icon :icon="item.icon"></v-icon>
                  {{ item.title }}
                </v-list-item-title>
              </v-list-item>

              <v-list-item>
                <v-list-item-title style="cursor: pointer" @click="logout"><v-icon>mdi-logout</v-icon> Logout</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </template>
  </v-app-bar>
</template>

<style scoped>
nav{
  position: fixed !important;
}

header{
  position: fixed !important;
}

#default-sidebar {
  background-color: #224562;
  color: #224562;
  background-image: url(https://colorlib.com/etc/bootstrap-sidebar/sidebar-06/images/bg_1.jpg);
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  border:none;
}

#default-sidebar::after{
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  content: '';
  background: #2f89fc;
  background: -moz-linear-gradient(45deg,#2f89fc 0%,#ff5db1 100%);
  background: -webkit-gradient(left bottom,right top,color-stop(0%,#2f89fc),color-stop(100%,#ff5db1));
  background: -webkit-linear-gradient(45deg,#2f89fc 0%,#ff5db1 100%);
  background: -o-linear-gradient(45deg,#2f89fc 0%,#ff5db1 100%);
  background: -ms-linear-gradient(45deg,#2f89fc 0%,#ff5db1 100%);
  background: linear-gradient(45deg,#2f89fc 0%,#ff5db1 100%);
  //background: linear-gradient(45deg,#ccc 0%,#cccccc 100%);
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#2f89fc',endColorstr='#ff5db1',GradientType=1 );
  opacity: .8;
  z-index: -1;
}

.new_theme{
  color: white !important;
}

.sub_new_theme{
  color: #161d28;
}
.sub_new_theme_text{
  color: #F5F5F5;
  font-weight: 900 !important;
  font-size: 14px !important;
}

.v-list .v-list-item--active {
  color: #F5F5F5;
  margin-bottom: 10px;
}

.custom_divider{
  color: white !important;
  margin-top: 5px;
}
</style>