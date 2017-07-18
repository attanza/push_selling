import Vuex from 'vuex'
import Vue from 'vue'

Vue.use(Vuex)

export const store = new Vuex.Store({
	state: {
		user: {},
		avatar: '',
		current_market: {},
		current_stokiest: {},
	},

	getters: {

	},

	mutations: {
		user_mutation(state, user){
			state.user = user
		},
		avatar_mutation(state, avatar){
			state.avatar = avatar
		},
		current_market_mutation(state, market){
			state.current_market = market
		},
		current_stokiest_mutation(state, stokiest){
			state.current_stokiest = stokiest
		}
	}
})
