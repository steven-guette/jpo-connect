import { Box } from '@mantine/core'

const BodySection = ({ children, bg = '#FFF', py = 'xl', px = 'md', style = {}, radius = '0', ...props }) => (
    <Box
        bg={bg}
        py={py}
        px={px}
        style={{
            color: '#000',
            borderRadius: radius,
            ...style
        }}
        {...props}
    >
        {children}
    </Box>
)

export default BodySection