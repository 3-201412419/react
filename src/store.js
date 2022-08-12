import { configureStore,createSlice  } from '@reduxjs/toolkit'

let user = createSlice({
    name : 'user',
    initialState : ['1','2','3']
  })

export default configureStore({
  reducer: {
    user : user.reducer
   }
}) 