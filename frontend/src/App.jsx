import { Routes, Route } from 'react-router-dom'
import { Loader, Center } from '@mantine/core'
import { useAuth } from './contexts/AuthContext'

import PrivateRoute from './components/atoms/Routes/PrivateRoute'
import DefaultLayout from './components/templates/DefaultLayout'

import Home from './pages/Home'
import Contact from './pages/Contact'
import About from './pages/About'
import Account from './pages/Account'
import Event from './pages/Event'
import EventDetail from './pages/EventDetail'
import Location from './pages/Location.jsx'
import LegalNotice from './pages/LegalNotice'
import CGU from './pages/CGU.jsx'
import NotFound from './pages/NotFound'

import './assets/css/App.css'

function App() {
    const { loading } = useAuth();

    if (loading) {
        return (
            <Center style={{ height: '100vh' }}>
                <Loader size={80} color="laplateforme.5" />
            </Center>
        )
    }

    return (
        <Routes>
            <Route element={<DefaultLayout />}>
                <Route index                    element={<Home />} />
                <Route path="/home"             element={<Home />} />
                <Route path="/contact"          element={<Contact />} />
                <Route path="/about"            element={<About />} />
                <Route path="/event"            element={<Event />} />
                <Route path="/event/:eventId"   element={<EventDetail />} />
                <Route path="/location"         element={<Location />} />
                <Route path="/legal-notice"     element={<LegalNotice />} />
                <Route path="/cgu"              element={<CGU />} />

                <Route  path="/account"         element={ <PrivateRoute children={<Account />} /> } />

                <Route path="*"                 element={<NotFound />} />
            </Route>
        </Routes>
    )
}

export default App
