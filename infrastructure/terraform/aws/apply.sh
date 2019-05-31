docker pull hashicorp/terraform:0.12.0

TERRAFORM_CMD="docker run \
  --network host \
  -w /app/infrastructure/terraform/aws \
  -v ${HOME}/.aws:/root/.aws \
  -v ${HOME}/.ssh:/root/.ssh \
  -v $(pwd):/app \
  -it \
  hashicorp/terraform:0.12.0"

echo TERRAFORM_CMD=$TERRAFORM_CMD

${TERRAFORM_CMD} apply -lock=false -input=false tfplan

