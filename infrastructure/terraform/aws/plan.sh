docker pull hashicorp/terraform:0.12.0

TERRAFORM_CMD="docker run \
  --network host \
  -w /app/infrastructure/terraform/aws \
  -v ${HOME}/.aws:/root/.aws \
  -v ${HOME}/.ssh:/root/.ssh \
  -v $(pwd):/app \
  hashicorp/terraform:0.12.0"

echo TERRAFORM_CMD=$TERRAFORM_CMD

${TERRAFORM_CMD} init -backend=true -input=false

${TERRAFORM_CMD} plan \
  -out=tfplan -input=false