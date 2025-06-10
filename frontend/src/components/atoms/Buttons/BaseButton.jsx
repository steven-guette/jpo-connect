import { Button as MantineButton } from '@mantine/core';

const BaseButton = ({ children, color, variant = 'filled', ...props }) => {
    return (
        <MantineButton
            variant={variant}
            color={color}
            radius="md"
            size="md"
            sx={{
                transition: 'transform 0.2s ease',
                '&:hover': {
                    transform: 'scale(1.05)',
                },
            }}
            {...props}
        >
            {children}
        </MantineButton>
    );
}

export default BaseButton;