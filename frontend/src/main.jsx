import React from 'react'
import ReactDOM from 'react-dom/client'
import App from './App'

import { MantineProvider } from '@mantine/core'
import { Notifications } from '@mantine/notifications'
import { BrowserRouter } from 'react-router-dom'
import { AuthProvider } from './contexts/AuthContext'

import GlobalStyles from './config/GlobalStyles.jsx'
import theme from './config/mantine/theme'
import components from './config/mantine/components'

import './assets/css/mantine.css'
import './assets/css/index.css'

ReactDOM.createRoot(document.getElementById('root')).render(
    <React.StrictMode>
        <MantineProvider withGlobalStyles withNormalizeCSS theme={theme} components={components}>

            <GlobalStyles />

            <Notifications
                position="top-center"
                transitionDuration={300}
                limit={5}
                zIndex={2077}
                containerWidth={700}
            />

            <AuthProvider>
                <BrowserRouter basename='/jpo-connect'>
                    <App />
                </BrowserRouter>
            </AuthProvider>
        </MantineProvider>
    </React.StrictMode>
)
