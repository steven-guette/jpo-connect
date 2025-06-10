import { Outlet } from 'react-router-dom'
import { Box } from '@mantine/core'
import BodyLine from '../atoms/Containers/BodyLine'
import Navbar from '../molecules/Navbar'
import Footer from '../organisms/Footer'

const DefaultLayout = () => {
    return (
        <Box component='main' style={{ display: 'flex', flexDirection: 'column', minHeight: '100vh' }}>
            <Navbar />
            <BodyLine style={{ flex: 1 }}>
                <Outlet />
            </BodyLine>
            <Footer />
        </Box>
    )
}

export default DefaultLayout;