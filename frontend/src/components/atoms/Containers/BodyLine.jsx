import { Container as MantineContainer } from '@mantine/core';

const BodyLine = ({ children, size = 'xl', px = { base: 'sm', sm: 'md', lg: 'lg' }, py = 'xl', bg = 'transparent', color = '#000', ...props }) => (
    <MantineContainer
        size={size}
        px={px}
        py={py}
        style={{
            backgroundColor: bg,
            color,
        }}
        {...props}
    >
        {children}
    </MantineContainer>
)

export default BodyLine;