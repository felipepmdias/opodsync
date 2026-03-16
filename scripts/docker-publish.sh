#!/usr/bin/env bash
set -euo pipefail

IMAGE_NAME="${1:-felipepmdias/opodsync}"
TAG="${2:-latest}"
PLATFORM="${PLATFORM:-linux/amd64}"

FULL_IMAGE="${IMAGE_NAME}:${TAG}"

echo "Building ${FULL_IMAGE}..."
docker build --platform "${PLATFORM}" -t "${FULL_IMAGE}" .

echo "Pushing ${FULL_IMAGE}..."
docker push "${FULL_IMAGE}"

echo "Done: ${FULL_IMAGE}"
